<template>
    <div class="login-wrapper">
        <div class="login-box">
            <h2>⚙️ Connexion Admin</h2>

            <input v-model="email" placeholder="Email" type="email" />
            <input v-model="password" placeholder="Mot de passe" type="password" />

            <button @click="login" :disabled="chargement">
                {{ chargement ? 'Connexion...' : 'Connexion' }}
            </button>

            <p class="erreur" v-if="error">{{ error }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const email = ref("");
const password = ref("");
const error = ref("");
const chargement = ref(false);

const login = async () => {
    chargement.value = true;
    error.value = "";

    try {
        const res = await fetch("http://127.0.0.1:8000/api/admin/login", {
            method: "POST",
            credentials: "include",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                email: email.value,
                password: password.value
            })
        });

        const data = await res.json();

        if (!res.ok) {
            error.value = data.message || "Identifiants incorrects.";
        } else {
            // Sauvegarder l'admin et rediriger
            localStorage.setItem("admin", JSON.stringify(data));
            router.push("/admin/resultats");
        }
    } catch (e) {
        error.value = "Erreur de connexion au serveur.";
    } finally {
        chargement.value = false;
    }
};
</script>

<style scoped>
.login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
}

.login-box {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

h2 {
    text-align: center;
    color: #1e293b;
    margin-bottom: 8px;
}

input {
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 15px;
    width: 100%;
}

button {
    padding: 12px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
}

button:disabled {
    background: #94a3b8;
    cursor: not-allowed;
}

.erreur {
    color: #dc2626;
    text-align: center;
    font-size: 14px;
}
</style>
