import { createRouter, createWebHistory } from "vue-router";

import Home from "../views/Home.vue";
import Blog from "../views/Blog.vue";
import Contact from "../views/Contact.vue";
import About from "../views/About.vue";
import SingleBlog from "../views/SingleBlog.vue";
import Login from "../views/user/Login.vue";
import Register from "../views/user/Register.vue";
import Dashboard from "../views/user/Dashboard.vue";
import createCategory from "../views/categories/create.vue";
import editCategory from "../views/categories/edit.vue";
import CategoryList from "../views/categories/index.vue";
import createBlog from "../views/blog/create.vue";
import BlogList from "../views/blog/Index.vue";
import EditBlog from "../views/blog/edit.vue";

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
        meta: { guest: true },
    },

    {
        path: "/register",
        name: "register",
        component: Register,
        meta: { guest: true },
    },

    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: { auth: true },
    },

    {
        path: "/create-category",
        name: "createCategory",
        component: createCategory,
        meta: { auth: true },
    },
    {
        path: "/category",
        name: "CategoryList",
        component: CategoryList,
        meta: { auth: true },
    },
    {
        path: "/category/edit/:id",
        name: "EditCategory",
        component: editCategory,
        meta: { auth: true },
    },

    // blog
    {
        path: "/create-blog",
        name: "createBlog",
        component: createBlog,
        meta: { auth: true },
    },
    {
        path: "/manage/blogs",
        name: "BlogList",
        component: BlogList,
        meta: { auth: true },
    },
    {
        path: "/blog/edit/:id",
        name: "EditBlog",
        component: EditBlog,
        meta: { auth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// before each route, check if the user is authenticated and meta is true or not
router.beforeEach((to, from, next) => {
    const loggedIn = sessionStorage.getItem("token");

    if (to.meta.guest && loggedIn) {
        next({ name: "dashboard" });
    } else if (to.meta.auth && !loggedIn) {
        next({ name: "login" });
    } else {
        next();
    }
});

export default router;
