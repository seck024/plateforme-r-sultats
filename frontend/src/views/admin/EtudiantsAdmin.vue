<template>
    <div>
        <h2>Administration des Étudiants</h2>

        <!-- FORMULAIRE -->
        <form @submit.prevent="addEtudiant">
            <input v-model="numero_etudiant" placeholder="Numéro étudiant" required />
            <input v-model="nom" placeholder="Nom" required />
            <input v-model="prenom" placeholder="Prénom" required />

            <!-- Select Diplôme → déclenche le chargement des années -->
            <select v-model="diplome_id" required @change="chargerAnneesDuDiplome">
                <option value="">-- Choisir un diplôme --</option>
                <option v-for="d in diplomes" :key="d.id" :value="d.id">
                    {{ d.nom }}
                </option>
            </select>

            <!-- Select Année → filtré par diplôme -->
            <select v-model="annee_id" required :disabled="!diplome_id">
                <option value="">-- Choisir une année --</option>
                <option v-for="a in annees" :key="a.id" :value="a.id">
                    {{ a.annee }}
                </option>
            </select>

            <button type="submit">Ajouter</button>
        </form>

        <!-- Message si aucune année pour ce diplôme -->
        <p v-if="diplome_id && annees.length === 0" class="warning">
            ⚠️ Aucune année disponible pour ce diplôme. Ajoutez-en une dans "Années".
        </p>

        <hr />

        <!-- LISTE -->
        <table>
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Diplôme</th>
                <th>Année</th>
                <th>Actions</th>
            </tr>
            <tr v-for="e in etudiants" :key="e.id">
                <td>{{ e.numero_etudiant }}</td>
                <td>{{ e.nom }}</td>
                <td>{{ e.prenom }}</td>
                <td>{{ getDiplomeNom(e.diplome_id) }}</td>
                <td>{{ getAnneeNom(e.annee_id) }}</td>
                <td>
                    <button @click="supprimer(e.id)" class="btn-red">
                        Supprimer
                    </button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            etudiants: [],
            diplomes: [],
            annees: [],
            toutesLesAnnees: [],
            numero_etudiant: "",
            nom: "",
            prenom: "",
            diplome_id: "",
            annee_id: ""
        };
    },

    mounted() {
        this.loadEtudiants();
        this.loadDiplomes();
        this.loadToutesLesAnnees();
    },

    methods: {
        async loadEtudiants() {
            const res = await fetch("http://127.0.0.1:8000/api/etudiants");
            this.etudiants = await res.json();
        },

        async loadDiplomes() {
            const res = await fetch("http://127.0.0.1:8000/api/diplomes");
            this.diplomes = await res.json();
        },

        async loadToutesLesAnnees() {
            const res = await fetch("http://127.0.0.1:8000/api/annees");
            this.toutesLesAnnees = await res.json();
        },

        // Charge les années filtrées par diplôme sélectionné
        async chargerAnneesDuDiplome() {
            this.annee_id = "";
            this.annees = [];
            if (!this.diplome_id) return;
            const res = await fetch(`http://127.0.0.1:8000/api/diplomes/${this.diplome_id}/annees`);
            this.annees = await res.json();
        },

        getDiplomeNom(id) {
            const d = this.diplomes.find(d => d.id === id);
            return d ? d.nom : id;
        },

        getAnneeNom(id) {
            const a = this.toutesLesAnnees.find(a => a.id === id);
            return a ? a.annee : id;
        },

        async addEtudiant() {
            if (!this.annee_id) {
                alert("Veuillez choisir une année d'examen.");
                return;
            }

            await fetch("http://127.0.0.1:8000/api/etudiants", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    numero_etudiant: this.numero_etudiant,
                    nom: this.nom,
                    prenom: this.prenom,
                    diplome_id: this.diplome_id,
                    annee_id: this.annee_id
                })
            });

            this.numero_etudiant = "";
            this.nom = "";
            this.prenom = "";
            this.diplome_id = "";
            this.annee_id = "";
            this.annees = [];

            this.loadEtudiants();
            this.loadToutesLesAnnees();
        },

        async supprimer(id) {
            if (!confirm("Supprimer cet étudiant ?")) return;
            await fetch(`http://127.0.0.1:8000/api/etudiants/${id}`, {
                method: "DELETE"
            });
            this.loadEtudiants();
        }
    }
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

input, select {
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
    min-width: 160px;
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
    font-size: 14px;
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

.btn-red {
    padding: 6px 12px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
</style>
