import auth from "./modules/auth";

require('./bootstrap')
import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import BootstrapVue from 'bootstrap-vue'
import App from './views/App.vue'
import Home from './views/Home.vue'
import './app.scss'
import Favourites from "./views/Favourites";

Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(BootstrapVue)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/web',
            name: 'home',
            component: Home
        },

        {
            path: '/web/favourites',
            name: 'favourites',
            component: Favourites
        }
    ],
})

const store = new Vuex.Store({
    state: {},

    modules: {
        auth: auth,
    }
})

const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
})
