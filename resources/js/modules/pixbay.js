import ApiClient from "../utils/apiClient";
export default {
    namespaced: true,

    state: () => ({
        photoCount: 0,
        photos: [],
        storeMessage: '',
    }),

    mutations: {
        SET_DATA: (state, payload) => {
            state.photos = payload.photos;
        },

        SET_STORE_MESSAGE: (state, payload) => {
            if (payload.error) {
                state.storeMessage = payload.error;
                return;
            }

            if (payload.errors) {
                state.storeMessage = payload.errors[Object.keys(payload.errors)[0]];
                return;
            }

            state.storeMessage = "Relax... your photo will be saved soon :)";

        },

        REMOVE_PHOTO: (state, payload) => {
            for (let i = 0; i < state.photos.length; i++) {
                if (state.photos[i].id === payload.id ) {
                    state.photos = state.photos.splice(state.photos, i);
                }
            }
        }
    },

    actions: {
        fetchPhotos: ({commit}, payload) => {
            ApiClient()
                .get('/pixbay/photos', {params: payload})
                .then(response => {
                    commit('SET_DATA', response.data);
                });
        },

        fetchPhotosFromDb: ({commit}, payload) => {
            ApiClient()
                .get('/photos/user', {params: payload})
                .then(response => {
                    commit('SET_DATA', response.data);
                });
        },

        storePhoto: ({commit}, payload) => {
            return ApiClient()
                .post('/photos/store', payload)
                .then(response => {
                    commit('SET_STORE_MESSAGE', response.data);
                });
        },

        removePhoto: ({commit}, payload) => {
            return ApiClient()
                .post('/photos/remove', payload)
                .then(() => {
                    commit('REMOVE_PHOTO', {id: payload.photoId});
                })
        }
    }
}
