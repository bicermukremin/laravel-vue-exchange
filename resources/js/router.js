import VueRouter from "vue-router";

import Vue from "vue";
Vue.use(VueRouter);

// admin project pages
import Home from "./pages/Home.vue";
import About from "./pages/About.vue";
import Faq from "./pages/Faq.vue";
import login from "./pages/Login";
import register from "./pages/Register";
import ExchangeDetail from "./components/exchange/ExchangeDetail.vue";
import Profile from "./components/profile/ProfileDetail.vue";
import PageNotAuthenticated from "./pages/PageNotAuthenticated";
import sendToken from "./pages/SendToken.vue";
import changePassword from "./pages/ChangePassword";
const routes = [
    {
        path: "/401",
        name: "PageNotAuthenticated",
        component: PageNotAuthenticated
    },
    {
        path: "/",
        component: Home,
        name: "Home"
        //meta: { onlyGuestUser: true }
    },
    {
        path: "/exchange-detail/:id",
        component: ExchangeDetail,
        name: "ExchangeDetail"
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
        path: "/profile",
        component: Profile,
        name: "Profile",
        meta: { onlyGuestUser: true }
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
    },

    {
        path: "/change-password/:id",
        name: "changePassword",
        component: changePassword,
        props: true,
        meta: { title: "changePassword" }
    },
    {
        path: "/send-token",
        name: "sendToken",
        component: sendToken,
        meta: { title: "sendToken" }
    }
];

export const router = new VueRouter({
    mode: "history",
    routes
});
