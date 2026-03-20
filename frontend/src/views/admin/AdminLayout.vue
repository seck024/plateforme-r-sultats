<template>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2>⚙️ Administration</h2>
            </div>
            <nav>
                <router-link to="/admin/filieres">📁 Filières</router-link>
                <router-link to="/admin/diplomes">🎓 Diplômes</router-link>
                <router-link to="/admin/etudiants">👥 Étudiants</router-link>
                <router-link to="/admin/resultats">📊 Résultats</router-link>
                <router-link to="/admin/annees">📅 Années</router-link>
            </nav>
            <div class="sidebar-footer">
                <router-link to="/">🌐 Voir le site public</router-link>
                <button @click="deconnecter">🚪 Déconnexion</button>
            </div>
        </aside>

        <!-- Contenu principal -->
        <main class="admin-content">
            <router-view />
        </main>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";
const router = useRouter();

const deconnecter = () => {
    localStorage.removeItem("admin");
    router.push("/login");
};
</script>

<style scoped>
.admin-wrapper {
    display: flex;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

.sidebar {
    width: 220px;
    background: #1e293b;
    color: white;
    display: flex;
    flex-direction: column;
    padding: 20px 0;
    position: fixed;
    height: 100vh;
}

.sidebar-logo {
    padding: 0 20px 20px;
    border-bottom: 1px solid #334155;
}

.sidebar-logo h2 {
    font-size: 16px;
    margin: 0;
}

nav {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 20px 0;
    gap: 4px;
}

nav a {
    color: #94a3b8;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 0;
    transition: all 0.2s;
    font-size: 14px;
}

nav a:hover,
nav a.router-link-active {
    background: #334155;
    color: white;
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid #334155;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.sidebar-footer a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 13px;
}

.sidebar-footer button {
    background: #dc2626;
    color: white;
    border: none;
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
}

.admin-content {
    margin-left: 220px;
    padding: 30px;
    flex: 1;
    background: #f8fafc;
    min-height: 100vh;
}
</style>
