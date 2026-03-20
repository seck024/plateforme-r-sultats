<template>
    <div>
        <h2>Administration des Années d'examen</h2>

        <!-- FORMULAIRE -->
        <form @submit.prevent="ajouterAnnee">

            <!-- Select Diplôme -->
            <select v-model="diplome_id" required>
                <option value="">-- Choisir un diplôme --</option>
                <option v-for="d in diplomes" :key="d.id" :value="d.id">
                    {{ d.nom }}
                </option>
            </select>

            <!-- Année -->
            <input
                v-model="annee"
                placeholder="Ex: 2025"
                type="number"
                min="2000"
                max="2100"
                required
            />

            <button type="submit">Ajouter</button>
        </form>

        <hr />

        <!-- LISTE -->
        <table>
            <tr>
                <th>Année</th>
                <th>Diplôme</th>
                <th>Filière</th>
                <th>Actions</th>
            </tr>

            <tr v-for="a in annees" :key="a.id">
                <td>{{ a.annee }}</td>
                <td>{{ getDiplomeNom(a.diplome_id) }}</td>
                <td>{{ getFiliereNom(a.diplome_id) }}</td>
                <td>
                    <button @click="supprimer(a.id)" class="btn btn-red">
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
            annees: [],
            diplomes: [],
            annee: "",
            diplome_id: "",
        };
    },

    mounted() {
        this.chargerAnnees();
        this.chargerDiplomes();
    },

    methods: {
        async chargerAnnees() {
            const res = await fetch("http://127.0.0.1:8000/api/annees");
            this.annees = await res.json();
        },

        async chargerDiplomes() {
            const res = await fetch("http://127.0.0.1:8000/api/diplomes");
            this.diplomes = await res.json();
        },

        getDiplomeNom(id) {
            const d = this.diplomes.find(d => d.id === id);
            return d ? d.nom : id;
        },

        getFiliereNom(diplome_id) {
            const d = this.diplomes.find(d => d.id === diplome_id);
            return d?.filiere?.nom ?? 'N/A';
        },

        async ajouterAnnee() {
            const res = await fetch("http://127.0.0.1:8000/api/annees", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    annee: this.annee,
                    diplome_id: this.diplome_id,
                }),
            });

            const data = await res.json();
            console.log("RÉPONSE :", data);

            this.annee = "";
            this.diplome_id = "";
            this.chargerAnnees();
        },

        async supprimer(id) {
            if (!confirm("Supprimer cette année ?")) return;
            await fetch(`http://127.0.0.1:8000/api/annees/${id}`, {
                method: "DELETE",
            });
            this.chargerAnnees();
        },
    },
};
</script>

<style scoped>
form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
    align-items: center;
}

select, input {
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
    min-width: 180px;
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

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #f1f5f9;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
    text-align: center;
}

.btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    margin: 2px;
}

.btn-red { background: #ef4444; color: white; }
</style>
