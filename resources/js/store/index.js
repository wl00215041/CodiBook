import Vue from 'vue'
import Vuex from 'vuex'
import books from './modules/books'
import mindmaps from './modules/mindmaps'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    books,
    mindmaps
  },
  state: {
    
  },
  mutations: {

  },
  strict: debug,
})