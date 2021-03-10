require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import BootstrapVue from 'bootstrap-vue'
import './app.scss';

Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(BootstrapVue)

import App from './views/App.vue'
import Home from './views/Home.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/web',
            name: 'home',
            component: Home
        },
    ],
});

const store = new Vuex.Store({
    state: {},

    modules: {}
})



const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
});

