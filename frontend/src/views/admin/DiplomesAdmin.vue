<script setup>
import { ref, onMounted } from "vue";
import api from "../../services/api";

// données
const diplomes = ref([]);
const filieres = ref([]);

const nom = ref("");
const filiere_id = ref("");

// --------------------
// CHARGER FILIERES
// --------------------
const chargerFilieres = async () => {
    const res = await api.get("/filieres");
    filieres.value = res.data;
};

// --------------------
// CHARGER DIPLOMES
// --------------------
const chargerDiplomes = async () => {
    const res = await api.get("/diplomes");
    diplomes.value = res.data;
};

// --------------------
// AJOUTER DIPLOME
// --------------------
const ajouterDiplome = async () => {
    if (!nom.value || !filiere_id.value) {
        alert("Veuillez remplir tous les champs");
        return;
    }

    await api.post("/diplomes", {
        nom: nom.value,
        filiere_id: filiere_id.value
    });

    nom.value = "";
    filiere_id.value = "";

    chargerDiplomes();
};

// --------------------
onMounted(() => {
    chargerFilieres();
    chargerDiplomes();
});
</script>

<template>
    <div>
        <h1>Administration – Diplômes</h1>

        <!-- AJOUT -->
        <h3>Ajouter un diplôme</h3>

        <input
            v-model="nom"
            placeholder="Nom du diplôme"
        />

        <select v-model="filiere_id">
            <option value="">-- Choisir une filière --</option>
            <option
                v-for="f in filieres"
                :key="f.id"
                :value="f.id"
            >
                {{ f.nom }}
            </option>
        </select>

        <button @click="ajouterDiplome">
            Ajouter
        </button>

        <!-- LISTE -->
        <h3>Liste des diplômes</h3>

        <table border="1" cellpadding="8">
            <tr>
                <th>Diplôme</th>
                <th>Filière</th>
            </tr>

            <tr v-for="d in diplomes" :key="d.id">
                <td>{{ d.nom }}</td>
                <td>{{ d.filiere?.nom }}</td>
            </tr>
        </table>
    </div>
</template>

<style>
input,
select {
    margin: 6px;
    padding: 6px;
}

button {
    padding: 6px 14px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #1d4ed8;
}
</style>
