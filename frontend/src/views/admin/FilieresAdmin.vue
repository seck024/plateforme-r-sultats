<script setup>
import { ref, onMounted } from "vue";
import api from "../../services/api";

const filieres = ref([]);
const nom = ref("");

const chargerFilieres = async () => {
    const res = await api.get("/filieres");
    filieres.value = res.data;
};

const ajouterFiliere = async () => {
    if (!nom.value) return;

    await api.post("/filieres", { nom: nom.value });
    nom.value = "";
    chargerFilieres();
};

onMounted(chargerFilieres);
</script>

<template>
    <div>
        <h1>Administration – Filières</h1>

        <h3>Ajouter une filière</h3>
        <input v-model="nom" placeholder="Nom de la filière" />
        <button @click="ajouterFiliere">Ajouter</button>

        <h3>Liste des filières</h3>
        <ul>
            <li v-for="f in filieres" :key="f.id">
                {{ f.nom }} (ID Filière :{{ f.id }})

            </li>
        </ul>
    </div>
</template>

