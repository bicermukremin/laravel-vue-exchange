import Axios from "axios";

export default {
    namespaced: true,
    state() {
        return {
            items: {},
            item: {}
        };
    },
    actions: {
        async getExchanges({ commit }) {
            await axios.get("/app/exchanges").then(res => {
                const exchanges = res.data.exchanges;
                commit("setExchanges", exchanges);
            });
        },
        async getExchangeDetail({ commit }, exchangeId) {
            await axios.get(`/app/exchanges/${exchangeId}`).then(res => {
                const exchange = res.data.exchange;
                commit("setExchangeDetail", exchange);
            });
        }
    },
    mutations: {
        setExchanges(state, exchanges) {
            state.items = exchanges;
        },
        setExchangeDetail(state, exchange) {
            state.item = exchange;
        }
    }
};
