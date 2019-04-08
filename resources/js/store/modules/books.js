// initial state
const state = {
    all: []
};

// getters
const getters = {};

// mutations
const mutations = {
    all(state, books) {
        state.all = books;
    }
};

// actions
const actions = {
    getList(context) {
        return axios.get("/books").then(res => {
            context.commit("all", res.data);
        });
    },
    deleteBook(context, id) {
        return axios.delete("/books/" + id).then(res => {
            context.dispatch("getList");
        });
    },
    getTOC(context, url) {
        return axios.post("/gettoc", {
            url: url
        });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
