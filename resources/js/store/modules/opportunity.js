export default {
    namespaced: true,
    state() {
        return {
            user: {
                profile: {},
                sendOpportunities: {},
                recievedOpportunities: {}
            }
        };
    },

    actions: {
        async fetchOpportunity({ commit }) {
            await axios.get("/app/opportunities").then(res => {
                if (res.data.status) {
                    commit("setOpportunity", res.data.user[0]);
                }
            });
        },
        createOpportunity({ commit }, payload) {
            commit("setOpportunity", payload[0]);
        }
    },
    mutations: {
        setOpportunity(state, payload) {
            state.user.profile = {
                id: payload.id,
                name: payload.name,
                avatar: payload.avatar
            };

            const sendOpportunities = payload.opportunities.filter(
                opp => opp.fromUser == payload.id
            );
            state.user.sendOpportunities = sendOpportunities;

            const recievedOpportunities = payload.opportunities.filter(
                opp => opp.toUser == payload.id
            );
            state.user.recievedOpportunities = recievedOpportunities;
        }
        /* addOpportunity(state, payload) {
            state.user.sendOpportunity.push(payload.sendOpportunity);
            state.user.recievedOpportunity.push(payload.recievedOpportunity);
        } */
    }
};
