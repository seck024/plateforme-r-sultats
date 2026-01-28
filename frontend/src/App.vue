<template>
    <div class="admin-container">
        <h1 class="admin-title">🎓 Administration</h1>

        <div class="admin-grid">
            <section class="admin-card">
                <h2>Filières</h2>
                <AdminFilieres />
            </section>

            <section class="admin-card">
                <h2>Diplômes</h2>
                <AdminDiplomes />
            </section>

            <section class="admin-card">
                <h2>Étudiants</h2>
                <AdminEtudiants />
            </section>

            <section class="admin-card">
                <h2>Résultats</h2>
                <AdminResultats />
            </section>
        </div>
    </div>
</template>

<script>
import AdminFilieres from "./views/admin/FilieresAdmin.vue";
import AdminDiplomes from "./views/admin/DiplomesAdmin.vue";
import AdminEtudiants from "./views/admin/EtudiantsAdmin.vue";
import AdminResultats from "./views/admin/ResultatsAdmin.vue";

export default {
    components: {
        AdminFilieres,
        AdminDiplomes,
        AdminEtudiants,
        AdminResultats,
    },
};
</script>

<style scoped>
/* PAGE */
.admin-container {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
    font-family: Arial, Helvetica, sans-serif;
    background: #f5f7fb;
    min-height: 100vh;
}

/* TITRE */
.admin-title {
    text-align: center;
    margin-bottom: 40px;
    color: #2c3e50;
    font-size: 32px;
}

/* GRID */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 25px;
}

/* CARTE */
.admin-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.admin-card h2 {
    margin-bottom: 15px;
    color: #34495e;
    border-bottom: 2px solid #3498db;
    padding-bottom: 5px;
}
</style>
