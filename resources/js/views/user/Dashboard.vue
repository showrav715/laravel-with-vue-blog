<template>
    <div id="backend-view">
        <div class="logout"><a href="#" @click="handleLogout">Log out</a></div>
        <h1 class="heading">Dashboard</h1>
        <span>Hi {{ user.name }}!</span>
        <div class="links">
            <ul>
                <li>
                    <router-link :to="{ name: 'createCategory' }"
                        >Create Categories</router-link
                    >
                </li>
                <li>
                    <router-link :to="{ name: 'CategoryList' }"
                        >Category List
                    </router-link>
                </li>

                <li>
                    <router-link :to="{ name: 'createBlog' }"
                        >Create Blog</router-link
                    >
                </li>

                <li>
                    <router-link :to="{ name: 'BlogList' }"
                        >Blog List</router-link
                    >
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { inject, onMounted, reactive, ref } from "vue";

const user = reactive({});
const handleLogout = inject("handleLogout");

onMounted(() => {
    axios.get("/api/user").then((response) => {
        user.name = response.data.name;
        user.email = response.data.email;
    });
});
</script>

<style scoped>
/* dashboard */
#backend-view {
    text-align: center;
    background-color: #f3f4f6;
    height: 100vh;
    padding-top: 15vh;
}

.logout {
    position: absolute;
    top: 30px;
    right: 40px;
}
.heading {
    margin-bottom: 5px;
}
.links {
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto;
    background: #ffffff;
    max-width: 500px;
    padding: 15px;
    border-radius: 15px;
}
.links ul {
    list-style: none;
}
.links a {
    all: revert;
    font-size: 26px;
    display: inline-block;
    margin: 10px 0;
}
</style>
