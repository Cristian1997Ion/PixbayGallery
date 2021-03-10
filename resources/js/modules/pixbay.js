import ApiClient from "../utils/apiClient";
export default {
    namespaced: true,

    state: () => ({
        photoCount: 0,
        photos: []
    }),

    mutations: {
        SET_DATA: (state, payload) => {
            state.photoCount = payload.photoCount;
            state.photos     = payload.photos;
        },
    },

    actions: {
        fetchPhotos: ({commit}, payload) => {
            ApiClient()
                .get('/pixbay/photos', {params: payload})
                .then(response => {
                    commit('SET_DATA', response.data);
                });
        }
    }
}
