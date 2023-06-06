import { createRouter, createWebHistory } from "vue-router";

import Home from "../views/Home.vue";
import Blog from "../views/Blog.vue";
import Contact from "../views/Contact.vue";
import About from "../views/About.vue";
import SingleBlog from "../views/SingleBlog.vue";
import Login from "../views/user/Login.vue";
import Register from "../views/user/Register.vue";
import Dashboard from "../views/user/Dashboard.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },
    {
        path: "/blog",
        name: "blog",
        component: Blog,
    },
    {
        path: "/blog/:slug",
        name: "single-blog",
        component: SingleBlog,
    },
    {
        path: "/contact",
        name: "contact",
        component: Contact,
    },
    {
        path: "/about",
        name: "about",
        component: About,
    },

    {
        path: "/login",
        name: "login",
        component: Login,
    },

    {
        path: "/register",
        name: "register",
        component: Register,
    },

    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard
    }


];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// before each route, check if the user is authenticated

// router.beforeEach((to, from, next) => {
//     if (to.matched.some((record) => record.meta.requiresAuth)) {
//         if (!localStorage.getItem("user")) {
//             next({ name: "login" });
//         } else {
//             next();
//         }
//     } else {
//         next();
//     }
// });

export default router;
