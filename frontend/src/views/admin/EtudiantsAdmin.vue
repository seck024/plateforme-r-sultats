
<template>
    <div>
        <h2>Administration des Étudiants</h2>
        <form @submit.prevent="addEtudiant">
            <input v-model="numero_etudiant" placeholder="Numéro étudiant" required />
            <input v-model="nom" placeholder="Nom" required />
            <input v-model="prenom" placeholder="Prénom" required />
            <input v-model="diplome_id" placeholder="ID diplôme" required />
            <input v-model="annee_id" placeholder="ID année" required />
            <button>Ajouter</button>
        </form>

        <ul>
            <li v-for="e in etudiants" :key="e.id">
                id_diplome :{{ e.diplome_id }}  - nom :{{ e.nom }}  -prenom :{{ e.prenom }}  -id_année :{{ e.annee_id }} -Numero_etudiant :{{ e.numero_etudiant }}
            </li>
        </ul>
    </div>
</template>

<script>

export default {
    data() {
        return {
            etudiants: [],
            numero_etudiant: "",
            nom: "",
            prenom: "",
            diplome_id: "",
            annee_id: ""
        };

    },
    mounted() {
        this.loadEtudiants();
    },
    methods: {
        async loadEtudiants() {
            const res = await fetch("http://localhost:8000/api/etudiants");
            this.etudiants = await res.json();
        },
        async addEtudiant() {
            console.log("ENVOYÉ :", {
                numero_etudiant: this.numero_etudiant,
                nom: this.nom,
                prenom: this.prenom,
                diplome_id: this.diplome_id,
                annee_id: this.annee_id
            });

            const res = await fetch("http://localhost:8000/api/etudiants", {
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

            const data = await res.json();
            console.log("RÉPONSE API :", data);

            this.loadEtudiants();
        }


    }
};
</script>
