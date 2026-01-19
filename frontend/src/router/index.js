import { createRouter, createWebHistory } from "vue-router";
import FilieresAdmin from "../views/admin/FilieresAdmin.vue";

const routes = [
    {
        path: "/admin/filieres",
        component: FilieresAdmin,
    },

];

export default createRouter({
    history: createWebHistory(),
    routes,
});

