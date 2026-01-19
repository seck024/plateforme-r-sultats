<template>
    <div>
        <h2>Administration des Diplômes</h2>

        <form @submit.prevent="addDiplome">
            <input v-model="nom" placeholder="Nom du diplôme" required />
            <input v-model="filiere_id" placeholder="ID Filière" required />
            <button>Ajouter</button>
        </form>

        <ul>
            <li v-for="d in diplomes" :key="d.filiere_id">
                {{ d.nom }} (Filière : {{ d.filiere_id }})
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            diplomes: [],
            nom: "",
            filiere_id: ""
        };
    },
    mounted() {
        this.loadDiplomes();
    },
    methods: {
        async loadDiplomes() {
            const res = await fetch("http://127.0.0.1:8000/api/diplomes");
            this.diplomes = await res.json();
        },
        async addDiplome() {
            await fetch("http://127.0.0.1:8000/api/diplomes", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    nom: this.nom,
                    filiere_id: this.filiere_id
                })
            });

            this.nom = "";
            this.filiere_id = "";
            this.loadDiplomes();
        }
    }
};
</script>
