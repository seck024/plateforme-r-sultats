import { createRouter, createWebHistory } from "vue-router";
import LoginAdmin from "../views/admin/LoginAdmin.vue";
import AdminDashboard from "../views/App.vue";
import App from "@/App.vue";

const routes = [
    { path: "/login", component: LoginAdmin },

    {
        path: "/admin",
        component: App,
        meta: { requiresAuth: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        const admin = localStorage.getItem("admin");
        if (!admin) return next("/login");
    }
    next();
});

export default router;
