import Vue from "vue";
import Vuex from "vuex";

import exchange from "./modules/exchange";
import user from "./modules/user";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        exchange,
        user
    },
    actions: {},
    mutations: {}
});
