<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const filieres = ref([]);

onMounted(async () => {
  try {
    const res = await api.get("/filieres");
    filieres.value = res.data;
  } catch (e) {
    console.error("Erreur API", e);
  }
});
</script>

<template>
  <div>
    <h1>TEST FILIÈRES</h1>
  </div>
</template>

