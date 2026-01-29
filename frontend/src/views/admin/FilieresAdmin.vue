<script setup>
import { ref, onMounted } from "vue";
import api from "../../services/api";

const filieres = ref([]);
const nom = ref("");

// --------------------
// CHARGER
// --------------------
const chargerFilieres = async () => {
    const res = await api.get("/filieres");
    filieres.value = res.data;
};

// --------------------
// AJOUTER
// --------------------
const ajouterFiliere = async () => {
    if (!nom.value) return;

    await api.post("/filieres", { nom: nom.value });
    nom.value = "";
    chargerFilieres();
};

// --------------------
// SUPPRIMER
// --------------------
const supprimer = async (id) => {
    if (!confirm("Voulez-vous vraiment supprimer cette filière ?")) {
        return;
    }

    await api.delete(`/filieres/${id}`);

    filieres.value = filieres.value.filter(f => f.id !== id);
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

        <table border="1" cellpadding="8">
            <tr>
                <th>Nom</th>
                <th>Action</th>
            </tr>

            <tr v-for="f in filieres" :key="f.id">
                <td>{{ f.nom }}</td>
                <td>
                    <button class="btn-delete" @click="supprimer(f.id)">
                        Supprimer
                    </button>
                </td>
            </tr>
        </table>
    </div>
</template>

<style>
.btn-delete {
    background: #dc2626;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

.btn-delete:hover {
    background: #b91c1c;
}
</style>
