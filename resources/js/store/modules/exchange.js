import { applyFilters } from "./../../helpers/index";

export default {
    namespaced: true,
    state() {
        return {
            items: {},
            item: {},
            loggedInUserExchanges: {}
        };
    },

    actions: {
        getList({ commit, state }, options) {
            const url = applyFilters("/app/exchanges", options.filter);

            axios.get(url).then(response => {
                let data = response.data.exchanges;
                //console.log(data);

                commit("setExchanges", data);
            });
        },

        async getExchanges({ commit }) {
            await axios.get("/app/exchanges").then(res => {
                const exchanges = res.data.exchanges;
                commit("setExchanges", exchanges);
            });
        },
        async getLoggedInUserExchanges({ commit }, userId) {
            await axios.get(`/app/users/${userId}`).then(res => {
                const exchanges = res.data.user[0].exchanges;
                commit("setUserExchanges", exchanges);
            });
        },
        async getExchangeDetail({ commit }, exchangeId) {
            await axios.get(`/app/exchanges/${exchangeId}`).then(res => {
                const exchange = res.data.exchange;
                commit("setExchangeDetail", exchange);
            });
        },

        createExchange({ commit }, payload) {
            commit("setExchangeDetail", payload);
            commit("addExchange", payload);
        }
    },
    mutations: {
        setExchanges(state, exchanges) {
            state.items = exchanges;
        },
        setUserExchanges(state, exchanges) {
            state.loggedInUserExchanges = exchanges;
        },
        setExchangeDetail(state, exchange) {
            state.item = exchange;
        },
        addExchange(state, exchange) {
            state.items.data.push(exchange);
        }
    }
};
