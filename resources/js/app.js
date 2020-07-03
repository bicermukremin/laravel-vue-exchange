require("./bootstrap");
window.Vue = require("vue");
import { router } from "./router";
import store from "./store";
import moment from "moment";
import Toasted from "vue-toasted";
import { isLoggedIn, isAdmin } from "./shared/utils/auth";

Vue.use(Toasted);
Vue.use(moment);
/* 
import ValidationErrors from "./shared/components/ValidationErrors";

import common from "./shared/mixins/common";
 */
import Vuelidate from "vuelidate";

Vue.config.productionTip = false;

Vue.use(Vuelidate);
//Vue.mixin(common);

//Vue.component("v-errors", ValidationErrors);
window.axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (401 === error.response.status) {
            store.dispatch("logout");
        }

        return Promise.reject(error);
    }
);

router.beforeEach((to, from, next) => {
    store.dispatch("user/fetchAuthUser").then(() => {
        const isAdmin = store.getters["user/isAdmin"];
        if (to.meta.onlyAuthUser) {
            if (isAdmin) {
                next();
            } else {
                next({ name: "PageNotAuthenticated" });
            }
        } else if (to.meta.onlyGuestUser) {
            if (isLoggedIn()) {
                next();
            } else {
                next({ name: "PageNotAuthenticated" });
            }
        } else {
            next();
        }
    });
});

Vue.filter("capitalize", function(value) {
    if (value && typeof value === "string") {
        return value.charAt(0).toUpperCase() + value.slice(1);
    }
    return "";
});
Vue.filter("formatDate", function(value, formatType = "LL") {
    if (!value) return "";
    return moment(value).format(formatType);
});
Vue.filter("fronNow", function(value) {
    if (!value) return "";
    return moment(value).fromNow();
});
Vue.component("pagination", require("laravel-vue-pagination"));
Vue.component("mainapp", require("./mainapp.vue").default);

const app = new Vue({
    el: "#app",
    router,
    store,
    created() {
        this.$store.dispatch("user/loadStateUser");
    }
});
