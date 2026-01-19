<template>
    <div>
        <h2>Administration des Étudiants</h2>

        <form @submit.prevent="addEtudiant">
            <input v-model="matricule" placeholder="Matricule" required />
            <input v-model="nom" placeholder="Nom" required />
            <input v-model="prenom" placeholder="Prénom" required />
            <input v-model="diplome_id" placeholder="ID Diplôme" required />
            <button>Ajouter</button>
        </form>

        <ul>
            <li v-for="e in etudiants" :key="e.id">
                {{ e.matricule }} - {{ e.nom }} {{ e.prenom }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            etudiants: [],
            matricule: "",
            nom: "",
            prenom: "",
            diplome_id: ""
        };
    },
    mounted() {
        this.loadEtudiants();
    },
    methods: {
        async loadEtudiants() {
            const res = await fetch("http://127.0.0.1:8000/api/etudiants");
            this.etudiants = await res.json();
        },
        async addEtudiant() {
            await fetch("http://127.0.0.1:8000/api/etudiants", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    matricule: this.matricule,
                    nom: this.nom,
                    prenom: this.prenom,
                    diplome_id: this.diplome_id
                })
            });

            this.matricule = "";
            this.nom = "";
            this.prenom = "";
            this.diplome_id = "";
            this.loadEtudiants();
        }
    }
};
</script>
