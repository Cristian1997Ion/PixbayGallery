import ApiClient from "../utils/apiClient";
import VueCookies from 'vue-cookies'

export default {
    namespaced: true,

    state: () => ({
        errors: null,
        user: {
            id: VueCookies.get('userid'),
            name: VueCookies.get('username'),
            token: VueCookies.get('token'),
        }
    }),

    mutations: {
        SET_DATA: (state, payload) => {
            if (payload.errors) {
                state.errors = payload.errors;

                return;
            }

            state.errors     = null;
            state.user.id    = payload.user.id;
            state.user.name  = payload.user.name;
            state.user.token = payload.user.token;

            VueCookies.set('username', payload.user.name, '1h');
            VueCookies.set('userid', payload.user.id, '1h');
            VueCookies.set('token', payload.user.token, '1h');

        },

        CLEAR: (state) => {
            state.errors     = null;
            state.user.id    = null;
            state.user.name  = null;
            state.user.token = null;

            VueCookies.remove('username');
            VueCookies.remove('userid');
            VueCookies.remove('token');
        }
    },

    actions: {
        login: ({commit}, payload) => {
            return ApiClient()
                .post('/login', payload)
                .then(response => {
                    commit('SET_DATA', response.data);
                })
        },

        register: ({commit}, payload) => {
            return ApiClient()
                .post('/register', payload)
                .then(response => {
                    commit('SET_DATA', response.data);
                })
        },

        signOut: ({commit}) => {
            return new Promise((resolve, reject) => {
                commit('CLEAR');
                console.log('cleared cookies');
                resolve();
            });
        }
    }
}
