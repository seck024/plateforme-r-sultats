<template>
    <div>
        <h1>ADMINISTRATION</h1>

        <AdminFilieres />
        <AdminDiplomes />
        <AdminEtudiants />
    </div>
</template>

<script>
import AdminFilieres from "./views/admin/FilieresAdmin.vue"
import AdminDiplomes from "./views/admin/DiplomesAdmin.vue";
import AdminEtudiants from "./views/admin/EtudiantsAdmin.vue";

export default {
    components: {
        AdminFilieres,
        AdminDiplomes,
        AdminEtudiants
    }
};
</script>
