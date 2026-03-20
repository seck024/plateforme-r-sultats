<template>
    <div class="page">
        <div class="container">
            <h1>📋 Consulter mes résultats</h1>
            <p class="subtitle">Sélectionnez votre filière, diplôme et année pour accéder à votre résultat.</p>

            <div class="steps-wrapper">

                <!-- Étape 1 : Filière -->
                <div class="step-block">
                    <label>1. Choisissez votre filière</label>
                    <select v-model="selectedFiliere" @change="onFiliereChange">
                        <option value="">-- Sélectionner une filière --</option>
                        <option v-for="f in filieres" :key="f.id" :value="f.id">
                            {{ f.nom }}
                        </option>
                    </select>
                </div>

                <!-- Étape 2 : Diplôme -->
                <div class="step-block" v-if="selectedFiliere">
                    <label>2. Choisissez votre diplôme</label>
                    <select v-model="selectedDiplome" @change="onDiplomeChange">
                        <option value="">-- Sélectionner un diplôme --</option>
                        <option v-for="d in diplomes" :key="d.id" :value="d.id">
                            {{ d.nom }}
                        </option>
                    </select>
                </div>

                <!-- Étape 3 : Année -->
                <div class="step-block" v-if="selectedDiplome">
                    <label>3. Choisissez l'année d'examen</label>
                    <select v-model="selectedAnnee">
                        <option value="">-- Sélectionner une année --</option>
                        <option v-for="a in annees" :key="a.id" :value="a.id">
                            {{ a.annee }}
                        </option>
                    </select>
                </div>

                <!-- Étape 4 : Numéro étudiant -->
                <div class="step-block" v-if="selectedAnnee">
                    <label>4. Entrez votre numéro étudiant</label>
                    <div class="input-row">
                        <input
                            v-model="identifiant"
                            placeholder="Ex: 20240001"
                            @keyup.enter="rechercherResultat"
                        />
                        <button @click="rechercherResultat" :disabled="!identifiant">
                            🔍 Rechercher
                        </button>
                    </div>
                </div>

            </div>

            <!-- Chargement -->
            <div v-if="chargement" class="loading">Recherche en cours...</div>

            <!-- Erreur -->
            <div v-if="erreur" class="erreur">
                ❌ {{ erreur }}
            </div>

            <!-- Résultat -->
            <div v-if="resultat" class="resultat-card">
                <div class="resultat-header">
                    <h2>Résultat de l'examen</h2>
                </div>

                <div class="resultat-info">
                    <p><strong>Étudiant :</strong> {{ resultat.nom }} {{ resultat.prenom }}</p>
                    <p><strong>Numéro :</strong> {{ resultat.numero_etudiant }}</p>
                </div>

                <div :class="['badge-statut', resultat.resultat?.statut]">
                    <span v-if="resultat.resultat?.statut === 'admis'">✅ ADMIS</span>
                    <span v-else-if="resultat.resultat?.statut === 'refuse'">❌ REFUSÉ</span>
                    <span v-else-if="resultat.resultat?.statut === 'rattrapage'">⚠️ RATTRAPAGE</span>
                </div>

                <!-- Stats globales -->
                <div class="stats-globales" v-if="stats">
                    <h3>📊 Statistiques de la promotion</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ stats.total }}</div>
                            <div class="stat-label">Étudiants</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value admis">{{ stats.admis }}</div>
                            <div class="stat-label">Admis</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ stats.taux_reussite }}%</div>
                            <div class="stat-label">Taux de réussite</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../services/api";

const filieres = ref([]);
const diplomes = ref([]);
const annees = ref([]);

const selectedFiliere = ref("");
const selectedDiplome = ref("");
const selectedAnnee = ref("");
const identifiant = ref("");

const resultat = ref(null);
const stats = ref(null);
const erreur = ref("");
const chargement = ref(false);

onMounted(async () => {
    const res = await api.get("/filieres");
    filieres.value = res.data;
});

const onFiliereChange = async () => {
    selectedDiplome.value = "";
    selectedAnnee.value = "";
    diplomes.value = [];
    annees.value = [];
    resultat.value = null;
    erreur.value = "";

    const res = await api.get(`/filieres/${selectedFiliere.value}/diplomes`);
    diplomes.value = res.data;
};

const onDiplomeChange = async () => {
    selectedAnnee.value = "";
    annees.value = [];
    resultat.value = null;
    erreur.value = "";

    const res = await api.get(`/diplomes/${selectedDiplome.value}/annees`);
    annees.value = res.data;
};

const rechercherResultat = async () => {
    if (!identifiant.value) return;

    erreur.value = "";
    resultat.value = null;
    stats.value = null;
    chargement.value = true;

    try {
        const res = await api.get("/public/resultats", {
            params: {
                diplome_id: selectedDiplome.value,
                annee_id: selectedAnnee.value,
                identifiant: identifiant.value,
            }
        });
        resultat.value = res.data.etudiant;
        stats.value = res.data.stats;
    } catch (e) {
        erreur.value = "Aucun résultat trouvé. Vérifiez votre numéro étudiant.";
    } finally {
        chargement.value = false;
    }
};
</script>

<style scoped>
.page {
    padding: 60px 0;
    background: #f8fafc;
    min-height: calc(100vh - 120px);
}

.container {
    max-width: 700px;
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
    margin-bottom: 36px;
}

/* Steps */
.steps-wrapper {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 32px;
}

.step-block {
    background: white;
    border-radius: 10px;
    padding: 20px 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.step-block label {
    display: block;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 10px;
    font-size: 15px;
}

.step-block select,
.step-block input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 15px;
    color: #1e293b;
    background: #f8fafc;
}

.input-row {
    display: flex;
    gap: 12px;
}

.input-row input {
    flex: 1;
}

.input-row button {
    padding: 10px 20px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    white-space: nowrap;
}

.input-row button:disabled {
    background: #94a3b8;
    cursor: not-allowed;
}

/* Résultat */
.resultat-card {
    background: white;
    border-radius: 12px;
    padding: 28px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.resultat-header h2 {
    font-size: 20px;
    color: #1e293b;
    margin-bottom: 16px;
}

.resultat-info {
    color: #475569;
    margin-bottom: 20px;
    line-height: 1.8;
}

.badge-statut {
    text-align: center;
    padding: 16px;
    border-radius: 10px;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 24px;
}

.badge-statut.admis {
    background: #dcfce7;
    color: #16a34a;
}

.badge-statut.refuse {
    background: #fee2e2;
    color: #dc2626;
}

.badge-statut.rattrapage {
    background: #fef9c3;
    color: #ca8a04;
}

/* Stats */
.stats-globales {
    border-top: 1px solid #e2e8f0;
    padding-top: 20px;
}

.stats-globales h3 {
    font-size: 16px;
    color: #1e293b;
    margin-bottom: 16px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.stat-item {
    background: #f8fafc;
    border-radius: 8px;
    padding: 16px;
    text-align: center;
}

.stat-value {
    font-size: 24px;
    font-weight: bold;
    color: #1e293b;
}

.stat-value.admis {
    color: #16a34a;
}

.stat-label {
    font-size: 12px;
    color: #64748b;
    margin-top: 4px;
}

/* Erreur / Loading */
.erreur {
    background: #fee2e2;
    color: #dc2626;
    padding: 16px;
    border-radius: 8px;
    text-align: center;
}

.loading {
    text-align: center;
    color: #64748b;
    padding: 20px;
}
</style>
