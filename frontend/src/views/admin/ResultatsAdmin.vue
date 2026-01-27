<template>
    <div>
        <h2>Administration des Résultats</h2>

        <!-- FORMULAIRE -->
        <form @submit.prevent="ajouterResultat">
            <input v-model="numero_etudiant" placeholder="Numéro étudiant" required />
            <input v-model="annee_id" placeholder="ID Année" required />

            <select v-model="statut">
                <option value="admis">Admis</option>
                <option value="rattrapage">Rattrapage</option>
                <option value="refuse">Refusé</option>
            </select>

            <button type="submit">Ajouter</button>
        </form>

        <hr />

        <!-- LISTE -->
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Étudiant</th>
                <th>Statut</th>
                <th>Validé</th>
                <th>Actions</th>
            </tr>

            <tr v-for="r in resultats" :key="r.id">
                <td>{{ r.id }}</td>

                <td>
                    {{ r.etudiant?.nom }} {{ r.etudiant?.prenom }}
                </td>

                <td>{{ r.statut }}</td>

                <td>{{ r.valide ? 'Oui' : 'Non' }}</td>

                <td>
                    <button
                        v-if="!r.valide"
                        @click="valider(r.id)"
                    >
                        Valider
                    </button>

                    <button
                        @click="supprimer(r.id)"
                        style="margin-left: 6px; color: red"
                    >
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
            resultats: [],
            numero_etudiant: "",
            annee_id: "",
            statut: "admis",
        };
    },

    mounted() {
        this.chargerResultats();
    },

    methods: {
        async chargerResultats() {
            const res = await fetch("http://127.0.0.1:8000/api/resultats");
            this.resultats = await res.json();
        },

        async ajouterResultat() {
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

            this.chargerResultats();
        },

        async valider(id) {
            await fetch(`http://127.0.0.1:8000/api/resultats/${id}/valider`, {
                method: "POST",
            });

            this.chargerResultats();
        },

        async supprimer(id) {
            if (!confirm("Supprimer ce résultat ?")) return;

            await fetch(`http://127.0.0.1:8000/api/resultats/${id}`, {
                method: "DELETE",
            });

            this.chargerResultats();
        },
    },
};
</script>
