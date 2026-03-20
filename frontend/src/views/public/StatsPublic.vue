<template>
    <div class="page">
        <div class="container">
            <h1> Taux de réussite</h1>
            <p class="subtitle">Résultats globaux publiés par filière et par diplôme.</p>

            <!-- Filtre année -->
            <div class="filtres">
                <label>Filtrer par année :</label>
                <select v-model="anneeFiltre" @change="chargerStats">
                    <option value="">Toutes les années</option>
                    <option v-for="a in annees" :key="a" :value="a">{{ a }}</option>
                </select>
            </div>

            <!-- Chargement -->
            <div v-if="chargement" class="loading">Chargement des statistiques...</div>

            <!-- Aucune donnée -->
            <div v-else-if="stats.length === 0" class="empty">
                Aucune statistique disponible pour le moment.
            </div>

            <!-- Stats par filière -->
            <div v-else>
                <div
                    v-for="filiere in statsGroupees"
                    :key="filiere.nom"
                    class="filiere-block"
                >
                    <h2>{{ filiere.nom }}</h2>

                    <div class="diplomes-grid">
                        <div
                            v-for="d in filiere.diplomes"
                            :key="d.diplome_id"
                            class="diplome-card"
                        >
                            <h3>{{ d.diplome_nom }}</h3>
                            <p class="annee">Session {{ d.annee }}</p>

                            <!-- Barre de progression -->
                            <div class="progress-bar">
                                <div
                                    class="progress-fill"
                                    :style="{ width: d.taux_reussite + '%' }"
                                    :class="getColorClass(d.taux_reussite)"
                                ></div>
                            </div>

                            <div class="taux-label">
                                <span :class="getColorClass(d.taux_reussite)">
                                    {{ d.taux_reussite }}% de réussite
                                </span>
                            </div>

                            <div class="stats-mini">
                                <span>{{ d.admis }} admis</span>
                                <span>{{ d.total }} candidats</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import api from "../../services/api";

const stats = ref([]);
const annees = ref([]);
const anneeFiltre = ref("");
const chargement = ref(true);

const chargerStats = async () => {
    chargement.value = true;
    try {
        const params = anneeFiltre.value ? { annee: anneeFiltre.value } : {};
        const res = await api.get("/public/statistiques", { params });
        stats.value = res.data;
    } catch (e) {
        console.error("Erreur stats", e);
    } finally {
        chargement.value = false;
    }
};

const chargerAnnees = async () => {
    try {
        const res = await api.get("/public/annees");
        annees.value = res.data;
    } catch (e) {
        console.error("Erreur années", e);
    }
};

// Grouper les stats par filière
const statsGroupees = computed(() => {
    const map = {};
    for (const s of stats.value) {
        if (!map[s.filiere_nom]) {
            map[s.filiere_nom] = { nom: s.filiere_nom, diplomes: [] };
        }
        map[s.filiere_nom].diplomes.push(s);
    }
    return Object.values(map);
});

const getColorClass = (taux) => {
    if (taux >= 75) return "vert";
    if (taux >= 50) return "orange";
    return "rouge";
};

onMounted(async () => {
    await chargerAnnees();
    await chargerStats();
});
</script>

<style scoped>
.page {
    padding: 60px 0;
    background: #f8fafc;
    min-height: calc(100vh - 120px);
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 24px;
}

h1 {
    font-size: 28px;
    color: #1e293b;
    margin-bottom: 8px;
}

.subtitle {
    color: #64748b;
    margin-bottom: 32px;
}

/* Filtre */
.filtres {
    background: white;
    padding: 16px 20px;
    border-radius: 10px;
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.filtres label {
    font-weight: 600;
    color: #1e293b;
}

.filtres select {
    padding: 8px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
}

/* Filière block */
.filiere-block {
    margin-bottom: 40px;
}

.filiere-block h2 {
    font-size: 20px;
    color: #1e293b;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e2e8f0;
}

.diplomes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

.diplome-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.diplome-card h3 {
    font-size: 16px;
    color: #1e293b;
    margin-bottom: 4px;
}

.annee {
    font-size: 13px;
    color: #94a3b8;
    margin-bottom: 16px;
}

/* Barre de progression */
.progress-bar {
    background: #e2e8f0;
    border-radius: 999px;
    height: 10px;
    margin-bottom: 8px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 999px;
    transition: width 0.6s ease;
}

.progress-fill.vert { background: #22c55e; }
.progress-fill.orange { background: #f59e0b; }
.progress-fill.rouge { background: #ef4444; }

.taux-label {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 12px;
}

.taux-label .vert { color: #16a34a; }
.taux-label .orange { color: #d97706; }
.taux-label .rouge { color: #dc2626; }

.stats-mini {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #94a3b8;
    border-top: 1px solid #f1f5f9;
    padding-top: 10px;
}

/* États */
.loading, .empty {
    text-align: center;
    color: #64748b;
    padding: 60px;
    background: white;
    border-radius: 12px;
}
</style>
