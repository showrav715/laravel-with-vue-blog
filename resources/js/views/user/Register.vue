<template>
    <div id="backend-view">
        <navbar />
        <form @submit.prevent="submit">
            <h3>Sign Up Here</h3>
            <label for="name">Name</label>
            <input type="text" id="name" v-model="data.name" />
            <span v-if="errors.name">{{ errors.name[0] }}</span>

            <label for="email">Email</label>
            <input type="text" id="email" v-model="data.email" />
            <span v-if="errors.email">{{ errors.email[0] }}</span>

            <label for="password">Password</label>
            <input type="password" id="password" v-model="data.password" />
            <span v-if="errors.password">{{ errors.password[0] }}</span>

            <label for="password_confirmation">Confirm password</label>
            <input
                type="password"
                id="password_confirmation"
                v-model="data.password_confirmation"
            />

            <button type="submit">Register</button>
            <span
                >Have an account?<router-link :to="{ name: 'login' }">
                    Log in </router-link
                ></span
            >
        </form>
    </div>
</template>

<script setup>
import { reactive, ref,inject } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const handleAuth = inject("handleAuth");


const router = useRouter();

const data = reactive({
    name: "",
    email: "",
    password: "",
    confirm_password: "",
});

const errors = ref({});

const submit = (e) => {
    e.preventDefault();
    axios
        .post("/api/register", data)
        .then((res) => {
            sessionStorage.setItem("token", res.data.access_token);
            handleAuth(true);
            router.push({ name: "dashboard" });
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
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
span {
    color: red;
    font-size: 14px;
    font-weight: 500;
    margin-top: 5px;
    display: block;
}
</style>
