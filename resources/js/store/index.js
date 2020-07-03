import Vue from "vue";
import Vuex from "vuex";

import exchange from "./modules/exchange";
import opportunity from "./modules/opportunity";
import user from "./modules/user";
import role from "./modules/role";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        exchange,
        user,
        role,
        opportunity
    },
    actions: {},
    mutations: {}
});
