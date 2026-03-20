<template>
    <div class="public-wrapper">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="navbar-brand">
                <router-link to="/">🎓 École Supérieure</router-link>
            </div>
            <div class="navbar-links">
                <router-link to="/">Accueil</router-link>
                <router-link to="/resultats">Mes résultats</router-link>
                <router-link to="/statistiques">Statistiques</router-link>
                <router-link to="/login" class="btn-admin">Admin</router-link>
            </div>
        </nav>

        <!-- Page -->
        <main class="public-content">
            <router-view />
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>© 2025 École Supérieure — Tous droits réservés</p>
        </footer>
    </div>
</template>

<script setup>
</script>

<style scoped>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.public-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

.navbar {
    background: #1e3a5f;
    padding: 16px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.navbar-brand a {
    color: white;
    text-decoration: none;
    font-size: 20px;
    font-weight: bold;
}

.navbar-links {
    display: flex;
    gap: 24px;
    align-items: center;
}

.navbar-links a {
    color: #cbd5e1;
    text-decoration: none;
    font-size: 15px;
    transition: color 0.2s;
}

.navbar-links a:hover,
.navbar-links a.router-link-active {
    color: white;
}

.btn-admin {
    background: #2563eb;
    color: white !important;
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px !important;
}

.btn-admin:hover {
    background: #1d4ed8;
}

.public-content {
    flex: 1;
}

.footer {
    background: #1e293b;
    color: #94a3b8;
    text-align: center;
    padding: 20px;
    font-size: 13px;
}
</style>
