// initial state
const state = {
  all: []
}

// getters
const getters = {}

// mutations
const mutations = {
  all(state,books) {
    state.all = books;
},
}

// actions
const actions = {
  getList(context){
    return axios.get('/mindmaps').then(
        (res)=>{
            context.commit('all', res.data);
        }
    )
  },
  deleteMindMaps(context, id){
      return axios.delete('/mindmaps/' + id).then(
              (res)=>{
                  context.dispatch('getList');
              }
      );
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}