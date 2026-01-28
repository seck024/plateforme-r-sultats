<template>
    <div class="admin-container">

        <!-- LOGIN -->
        <div v-if="!admin" class="login-box">
            <h2 class="title">Connexion Administrateur</h2>

            <input v-model="email" placeholder="Email">
            <input v-model="password" type="password" placeholder="Mot de passe">

            <button @click="login">Se connecter</button>
        </div>

        <!-- ADMIN -->
        <div v-else>
            <div class="top-bar">
                <h2>Bienvenue {{ admin.name }}</h2>
                <button class="logout" @click="logout">Déconnexion</button>
            </div>

            <div class="admin-grid">

                <!-- ligne 1 -->
                <div class="admin-card">
                    <AdminFilieres />
                </div>

                <div class="admin-card">
                    <AdminDiplomes />
                </div>

                <!-- ligne 2 : plein écran -->
                <div class="admin-card full-width">
                    <AdminEtudiants />
                </div>

                <!-- ligne 3 : plein écran -->
                <div class="admin-card full-width">
                    <AdminResultats />
                </div>

            </div>

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
        AdminResultats
    },

    data() {
        return {
            admin: null,
            email: "",
            password: ""
        };
    },

    async mounted() {
        try {
            const res = await fetch("http://127.0.0.1:8000/api/admin/me", {
                credentials: "include"
            });

            if (res.ok) {
                const data = await res.json();
                this.admin = data.admin;
            }
        } catch (e) {
            console.log("Non connecté");
        }
    },

    methods: {
        async login() {
            const res = await fetch("http://127.0.0.1:8000/api/admin/login", {
                method: "POST",
                credentials: "include",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    email: this.email,
                    password: this.password
                })
            });

            const data = await res.json();

            if (res.ok) {
                this.admin = data.admin;
            } else {
                alert(data.message);
            }
        },

        async logout() {
            await fetch("http://127.0.0.1:8000/api/admin/logout", {
                method: "POST",
                credentials: "include"
            });

            this.admin = null;
        }
    }
};
</script>

<style scoped>
.admin-container {
    min-height: 100vh;
    background: #f4f6fb;
    padding: 40px;
    font-family: "Segoe UI", Arial, sans-serif;
}

/* LOGIN */
.login-box {
    width: 350px;
    margin: 120px auto;
    background: white;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
}

.login-box h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #2c3e50;
}

.login-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.login-box button {
    width: 100%;
    padding: 12px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
}

.login-box button:hover {
    background: #1d4ed8;
}

/* TOP BAR */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.top-bar h2 {
    color: #1f2937;
}

.logout {
    background: #ef4444;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
}

.logout:hover {
    background: #dc2626;
}

/* GRID */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
}

/* CARD */
.admin-card {
    background: white;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.full-width {
    grid-column: 1 / -1;
}

</style>
