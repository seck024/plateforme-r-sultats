<template>
    <div>
        <h2>Administration des Résultats</h2>

        <!-- FORMULAIRE -->
        <form @submit.prevent="ajouterResultat">

            <!-- Select Étudiant → déclenche le chargement des années -->
            <select v-model="numero_etudiant" required @change="chargerAnneesDeLEtudiant">
                <option value="">-- Choisir un étudiant --</option>
                <option v-for="e in etudiants_liste" :key="e.id" :value="e.numero_etudiant">
                    {{ e.numero_etudiant }} - {{ e.nom }} {{ e.prenom }}
                </option>
            </select>

            <!-- Select Année → filtré par étudiant/diplôme -->
            <select v-model="annee_id" required :disabled="!numero_etudiant">
                <option value="">-- Choisir une année --</option>
                <option v-for="a in annees" :key="a.id" :value="a.id">
                    {{ a.annee }}
                </option>
            </select>

            <!-- Select Statut -->
            <select v-model="statut">
                <option value="admis">Admis</option>
                <option value="rattrapage">Rattrapage</option>
                <option value="refuse">Refusé</option>
            </select>

            <button type="submit">Ajouter</button>
        </form>

        <!-- Avertissement si aucune année -->
        <p v-if="numero_etudiant && annees.length === 0" class="warning">
            ⚠️ Aucune année disponible pour cet étudiant.
        </p>

        <hr />

        <!-- LISTE -->
        <table>
            <tr>
                <th>Numéro étudiant</th>
                <th>Étudiant</th>
                <th>Statut</th>
                <th>Validé</th>
                <th>Publié</th>
                <th>Actions</th>
            </tr>

            <tr v-for="r in resultats" :key="r.id">
                <td>{{ r.etudiant?.numero_etudiant }}</td>
                <td>{{ r.etudiant?.nom }} {{ r.etudiant?.prenom }}</td>
                <td>{{ r.statut }}</td>
                <td>{{ r.valide ? 'Oui' : 'Non' }}</td>
                <td>{{ r.publie ? 'Oui' : 'Non' }}</td>
                <td>
                    <!-- Valider -->
                    <button v-if="!r.valide" @click="valider(r.id)" class="btn btn-blue">
                        Valider
                    </button>

                    <!-- Publier -->
                    <button v-if="r.valide && !r.publie" @click="publier(r.id)" class="btn btn-green">
                        Publier
                    </button>

                    <!-- Badge publié -->
                    <span v-if="r.publie" class="badge-publie">✅ Publié</span>

                    <!-- Supprimer -->
                    <button @click="supprimer(r.id)" class="btn btn-red">
                        Supprimer
                    </button>
                </td>
            </tr>
        </table>

        <!-- Modal partage social -->
        <div v-if="modalVisible" class="modal-overlay" @click="modalVisible = false">
            <div class="modal" @click.stop>
                <h3>📢 Partager le taux de réussite</h3>
                <p class="modal-texte">{{ modalTexte }}</p>
                <div class="modal-buttons">
                    <button @click="copierTexte" class="btn btn-blue">📋 Copier</button>
                    <button @click="modalVisible = false" class="btn btn-gray">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            resultats: [],
            etudiants_liste: [],
            annees: [],
            numero_etudiant: "",
            annee_id: "",
            statut: "admis",
            modalVisible: false,
            modalTexte: "",
        };
    },

    mounted() {
        this.chargerResultats();
        this.chargerEtudiants();
    },

    methods: {
        async chargerResultats() {
            const res = await fetch("http://127.0.0.1:8000/api/resultats");
            this.resultats = await res.json();
        },

        async chargerEtudiants() {
            const res = await fetch("http://127.0.0.1:8000/api/etudiants");
            this.etudiants_liste = await res.json();
        },

        // Charge les années filtrées selon le diplôme de l'étudiant
        async chargerAnneesDeLEtudiant() {
            this.annee_id = "";
            this.annees = [];
            if (!this.numero_etudiant) return;

            const etudiant = this.etudiants_liste.find(
                e => e.numero_etudiant === this.numero_etudiant
            );
            if (!etudiant) return;

            const res = await fetch(
                `http://127.0.0.1:8000/api/diplomes/${etudiant.diplome_id}/annees`
            );
            this.annees = await res.json();
        },

        async ajouterResultat() {
            if (!this.annee_id) {
                alert("Veuillez choisir une année.");
                return;
            }

            await fetch("http://127.0.0.1:8000/api/resultats", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    numero_etudiant: this.numero_etudiant,
                    annee_id: this.annee_id,
                    statut: this.statut,
                }),
            });

            this.numero_etudiant = "";
            this.annee_id = "";
            this.statut = "admis";
            this.annees = [];

            this.chargerResultats();
        },

        async valider(id) {
            await fetch(`http://127.0.0.1:8000/api/resultats/${id}/valider`, {
                method: "POST",
            });
            this.chargerResultats();
        },

        async publier(id) {
            const res = await fetch(`http://127.0.0.1:8000/api/resultats/${id}/publier`, {
                method: "POST",
            });
            const data = await res.json();

            if (data.taux_reussite !== undefined) {
                this.modalTexte = `🎓 Résultats publiés ! Taux de réussite : ${data.taux_reussite}% — Félicitations aux admis !`;
                this.modalVisible = true;
            }

            this.chargerResultats();
        },

        async supprimer(id) {
            if (!confirm("Supprimer ce résultat ?")) return;
            await fetch(`http://127.0.0.1:8000/api/resultats/${id}`, {
                method: "DELETE",
            });
            this.chargerResultats();
        },

        copierTexte() {
            navigator.clipboard.writeText(this.modalTexte);
            alert("Texte copié !");
        },
    },
};
</script>

<style scoped>
form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 12px;
    align-items: center;
}

select {
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
    min-width: 200px;
}

select:disabled {
    background: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
}

button[type="submit"] {
    padding: 8px 20px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.warning {
    color: #d97706;
    background: #fef9c3;
    padding: 8px 14px;
    border-radius: 6px;
    font-size: 14px;
    margin-bottom: 12px;
}

table { width: 100%; border-collapse: collapse; }
th { background: #f1f5f9; }
th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: center; }

.btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    margin: 2px;
}

.btn-blue  { background: #3b82f6; color: white; }
.btn-green { background: #22c55e; color: white; }
.btn-red   { background: #ef4444; color: white; }
.btn-gray  { background: #64748b; color: white; }

.badge-publie {
    background: #dcfce7;
    color: #16a34a;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 13px;
    margin: 2px;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal {
    background: white;
    padding: 32px;
    border-radius: 12px;
    max-width: 480px;
    width: 90%;
    text-align: center;
}

.modal h3 { color: #1e293b; margin-bottom: 16px; }

.modal-texte {
    background: #f8fafc;
    padding: 16px;
    border-radius: 8px;
    color: #475569;
    font-size: 15px;
    margin-bottom: 20px;
}

.modal-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}
</style>
