<template>
    <div>
        <!-- Hero -->
        <section class="hero">
            <div class="hero-content">
                <h1>Bienvenue sur la plateforme de résultats</h1>
                <p>Consultez vos résultats d'examens en toute simplicité et en toute confidentialité.</p>
                <div class="hero-buttons">
                    <router-link to="/resultats" class="btn-primary">
                        📋 Consulter mes résultats
                    </router-link>
                    <router-link to="/statistiques" class="btn-secondary">
                        📊 Voir les statistiques
                    </router-link>
                </div>
            </div>
        </section>

        <!-- Filières -->
        <section class="filieres-section">
            <div class="container">
                <h2>Nos filières</h2>
                <p class="subtitle">Découvrez nos formations disponibles</p>

                <div v-if="chargement" class="loading">Chargement...</div>

                <div v-else class="filieres-grid">
                    <div
                        v-for="f in filieres"
                        :key="f.id"
                        class="filiere-card"
                    >
                        <div class="filiere-icon">🎓</div>
                        <h3>{{ f.nom }}</h3>
                        <router-link to="/resultats" class="card-link">
                            Voir les résultats →
                        </router-link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comment ça marche -->
        <section class="how-section">
            <div class="container">
                <h2>Comment consulter vos résultats ?</h2>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h3>Choisissez votre filière</h3>
                        <p>Sélectionnez la filière dans laquelle vous êtes inscrit.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h3>Sélectionnez votre diplôme</h3>
                        <p>Choisissez le diplôme et l'année d'examen concernés.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h3>Entrez votre numéro</h3>
                        <p>Saisissez votre numéro étudiant pour accéder à votre résultat.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../services/api";

const filieres = ref([]);
const chargement = ref(true);

onMounted(async () => {
    try {
        const res = await api.get("/filieres");
        filieres.value = res.data;
    } catch (e) {
        console.error("Erreur chargement filières", e);
    } finally {
        chargement.value = false;
    }
});
</script>

<style scoped>
/* Hero */
.hero {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    color: white;
    padding: 80px 40px;
    text-align: center;
}

.hero h1 {
    font-size: 36px;
    margin-bottom: 16px;
}

.hero p {
    font-size: 18px;
    color: #bfdbfe;
    margin-bottom: 32px;
}

.hero-buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary {
    background: white;
    color: #1e3a5f;
    padding: 14px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    font-size: 15px;
    transition: transform 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
}

.btn-secondary {
    background: transparent;
    color: white;
    padding: 14px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 15px;
    border: 2px solid white;
    transition: background 0.2s;
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.1);
}

/* Sections */
.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
}

.filieres-section {
    padding: 60px 0;
    background: #f8fafc;
}

.filieres-section h2,
.how-section h2 {
    font-size: 28px;
    color: #1e293b;
    text-align: center;
    margin-bottom: 8px;
}

.subtitle {
    text-align: center;
    color: #64748b;
    margin-bottom: 40px;
}

.filieres-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 24px;
}

.filiere-card {
    background: white;
    border-radius: 12px;
    padding: 28px 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    transition: transform 0.2s;
}

.filiere-card:hover {
    transform: translateY(-4px);
}

.filiere-icon {
    font-size: 36px;
    margin-bottom: 12px;
}

.filiere-card h3 {
    color: #1e293b;
    margin-bottom: 16px;
    font-size: 16px;
}

.card-link {
    color: #2563eb;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

/* Comment ça marche */
.how-section {
    padding: 60px 0;
    background: white;
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    margin-top: 40px;
}

.step-card {
    text-align: center;
    padding: 24px;
}

.step-number {
    width: 48px;
    height: 48px;
    background: #2563eb;
    color: white;
    border-radius: 50%;
    font-size: 20px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.step-card h3 {
    color: #1e293b;
    margin-bottom: 8px;
}

.step-card p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
}

.loading {
    text-align: center;
    color: #64748b;
    padding: 40px;
}
</style>
