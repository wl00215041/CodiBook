
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueRouter from 'vue-router';
import routes from './routes.js';
import iView from 'iview';
import store from './store'
import 'iview/dist/styles/iview.css';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faSave, faPlus, faMinus, faAngleDoubleUp, 
         faAngleDoubleDown, faFolderOpen, faSearchPlus, 
         faSearchMinus, faLevelDownAlt, faLevelUpAlt, faArrowsAlt, faCamera, faFileExport } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faSave, faPlus, faMinus, faAngleDoubleUp, 
            faAngleDoubleDown, faFolderOpen, faSearchPlus, 
            faSearchMinus, faLevelDownAlt, faLevelUpAlt, faArrowsAlt, faCamera, faFileExport)

Vue.component('font-awesome', FontAwesomeIcon)
Vue.component('header-nav', require('./components/Nav.vue'));
Vue.use(VueRouter);
Vue.use(iView);
const router = new VueRouter({
    routes
});

const app = new Vue({
    el: '#app',
    router,
    store
});
