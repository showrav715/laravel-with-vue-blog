<template>
    <div id="backend-view">
        <form @submit.prevent="submit" method="post">
            <h3>Login</h3>

            <label for="email">Email</label>
            <input type="text" id="email" v-model="data.email" />
            <span v-if="errors.email">{{ errors.email[0] }}</span>
            <label for="password">Password</label>
            <input type="password" id="password" v-model="data.password" />
            <span v-if="errors.password">{{ errors.password[0] }}</span>

            <span v-if="unauthenticated">{{ unauthenticated }}</span>
            <button type="submit">Login</button>
            <span
                >Create an account?
                <router-link :to="{ name: 'register' }"> Register</router-link>
            </span>
        </form>
    </div>
</template>

<script setup>
import { inject, reactive, ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
const data = reactive({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const errors = ref({});
const unauthenticated = ref("");
const handleAuth = inject("handleAuth");

const submit = (e) => {
    e.preventDefault();

    axios
        .post("/api/login", data)
        .then((res) => {
            sessionStorage.setItem("token", res.data.access_token);
            handleAuth(true);
            router.push({ name: "dashboard" });
        })
        .catch((err) => {
            if (err.response.data.status_code == 401) {
                unauthenticated.value = err.response.data.message;
                errors.value = "";
            } else {
                errors.value = err.response.data.errors;
                unauthenticated.value = "";
            }
        });
};
</script>

<style scoped>
#backend-view {
    height: 100vh;
    background-color: #f3f4f6;
    display: grid;
    align-items: center;
}
span {
    color: red;
    font-size: 14px;
    font-weight: 500;
    margin-top: 5px;
    display: block;
}
form {
    width: 400px;
    background-color: #ffffff;
    margin: 0 auto;
    border-radius: 10px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    padding: 50px 35px;
}
form * {
    letter-spacing: 0.5px;
    outline: none;
}

label {
    display: block;
    margin-top: 20px;
    font-size: 16px;
    font-weight: 500;
}
input {
    display: block;
    height: 50px;
    width: 100%;
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 16px;
    font-weight: 300;
}

button {
    margin-top: 50px;
    width: 100%;
    background-color: rgba(0, 46, 173, 0.7);
    color: #ffffff;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
form span {
    display: block;
    margin-top: 20px;
}
a {
    color: rgba(0, 46, 173, 0.8);
}

.loader {
    text-align: center;
    margin-bottom: 15px;
}
</style>
