import { createRouter, createWebHistory } from "vue-router";

// Auth
import LoginAdmin from "../views/admin/LoginAdmin.vue";

// Admin
import AdminLayout from "../views/admin/AdminLayout.vue";
import FilieresAdmin from "../views/admin/FilieresAdmin.vue";
import DiplomesAdmin from "../views/admin/DiplomesAdmin.vue";
import EtudiantsAdmin from "../views/admin/EtudiantsAdmin.vue";
import ResultatsAdmin from "../views/admin/ResultatsAdmin.vue";

// Public
import PublicLayout from "../views/public/PublicLayout.vue";
import HomeView from "../views/public/HomeView.vue";
import ResultatsPublic from "../views/public/ResultatsPublic.vue";
import StatsPublic from "../views/public/StatsPublic.vue";
import AnneesAdmin from "../views/admin/AnneesAdmin.vue";

const routes = [
    // ─── Page login ───────────────────────────────────────
    { path: "/login", component: LoginAdmin },

    // ─── Interface publique ───────────────────────────────
    {
        path: "/",
        component: PublicLayout,
        children: [
            { path: "", component: HomeView },
            { path: "resultats", component: ResultatsPublic },
            { path: "statistiques", component: StatsPublic },

        ]
    },

    // ─── Interface admin (protégée) ───────────────────────
    {
        path: "/admin",
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            { path: "filieres", component: FilieresAdmin },
            { path: "diplomes", component: DiplomesAdmin },
            { path: "etudiants", component: EtudiantsAdmin },
            { path: "resultats", component: ResultatsAdmin },
            { path: "annees", component: AnneesAdmin },
        ]
    },

    // Redirection par défaut
    { path: "/:pathMatch(.*)*", redirect: "/" }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// authentification
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        const admin = localStorage.getItem("admin");
        if (!admin) return next("/login");
    }
    next();
});

export default router;
