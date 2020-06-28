import VueRouter from "vue-router";

import Vue from "vue";
Vue.use(VueRouter);

// admin project pages
import Home from "./pages/Home.vue";
import About from "./pages/About.vue";
import Faq from "./pages/Faq.vue";
import login from "./pages/Login";
import register from "./pages/Register";
/* import sendToken from "./auth/SendToken";
import changePassword from "./auth/ChangePassword"; */
const routes = [
    {
        path: "/",
        component: Home,
        name: "Home"
        //meta: { onlyGuestUser: true }
    },
    {
        path: "/about",
        component: About,
        name: "About"
        //meta: { onlyGuestUser: true }
    },
    {
        path: "/faq",
        component: Faq,
        name: "Faq"
        //meta: { onlyGuestUser: true }
    },

    {
        path: "/login",
        name: "login",
        component: login
        // meta: { title: "login" }
    },
    {
        path: "/register",
        name: "register",
        component: register
        //meta: { title: "register" }
    }
    /* {
        path: "/send-token",
        name: "sendToken",
        component: sendToken,
        meta: { title: "sendToken" }
    },
    {
        path: "/change-password/:id",
        name: "changePassword",
        component: changePassword,
        props: true,
        meta: { title: "changePassword" }
    } */
];

export const router = new VueRouter({
    mode: "history",
    routes
});
