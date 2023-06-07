<template>
    <div id="wrapper">
        <div class="sidebar">
            <span class="closeButton">&times;</span>
            <p class="brand-title"><a href="">Alphayo Blog</a></p>
            <div class="side-links">
                <ul>
                    <li>
                        <router-link :to="{ name: 'home' }" class="active"
                            >Home</router-link
                        >
                    </li>
                    <li>
                        <router-link :to="{ name: 'blog' }" class="active"
                            >Blog</router-link
                        >
                    </li>
                    <li>
                        <router-link :to="{ name: 'about' }" class="active"
                            >About</router-link
                        >
                    </li>
                    <li>
                        <router-link :to="{ name: 'contact' }" class="active"
                            >Contact</router-link
                        >
                    </li>

                    <div v-if="!auth">
                        <li>
                            <router-link :to="{ name: 'login' }" class="active"
                                >Login</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                :to="{ name: 'register' }"
                                class="active"
                                >Register</router-link
                            >
                        </li>
                    </div>

                    <li v-if="auth">
                        <router-link :to="{ name: 'dashboard' }" class="active"
                            >Dashboard</router-link
                        >
                    </li>
                </ul>
            </div>
        </div>
        <!-- Menu Button -->
        <div class="menuButton">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <!-- main -->
        <main class="container">
            <router-view></router-view>
            <!-- Main footer -->
            <footer class="main-footer">
                <div>
                    <a href=""><i class="fab fa-facebook-f"></i></a>
                    <a href=""><i class="fab fa-instagram"></i></a>
                    <a href=""><i class="fab fa-twitter"></i></a>
                </div>
                <small>&copy; 2021 Blog</small>
            </footer>
        </main>
    </div>
</template>

<script setup>
import { provide, ref, onMounted } from "vue";
const auth = ref(false);
onMounted(() => {
    if (sessionStorage.getItem("token")) {
        auth.value = true;
    }
    provide("auth", auth);
    

    const handleAuth =(isAuth) => {
        auth.value = isAuth;
        provide("auth", auth);
    }
    provide("handleAuth", handleAuth);
});
</script>
