<template>
    <div class="login-box">
        <h2>Connexion Admin</h2>

        <input v-model="email" placeholder="Email" />
        <input type="password" v-model="password" placeholder="Mot de passe" />

        <button @click="login">Connexion</button>

        <p v-if="error">{{ error }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: "",
            error: ""
        };
    },

    methods: {
        async login() {
            const res = await fetch("http://127.0.0.1:8000/api/admin/login", {
                method: "POST",
                credentials: "include",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    email: this.email,
                    password: this.password
                })
            });

            const data = await res.json();

            if (!res.ok) {
                this.error = data.message;
            } else {
                this.$emit("connected");
            }
        }
    }
};
</script>
