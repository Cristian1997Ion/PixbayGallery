<template>
    <div>
        <div v-if="!authenticated">In order to view this page, please authenticate.</div>
        <div class="row pt-3" v-if="authenticated && photos.length > 0">
            <pixbay-photo
                v-for="photo in photos"
                v-bind:key="photo.id"
                :photo="photo"
                :ref="'photo_' + photo.id"
                class="mb-2 col-md-4"
                :show-add-to-favourites="false"
                :show-author="false"
                @deletePhoto="onDeletePhoto"
            />
        </div>
        <div class="row pt-3" v-if="authenticated">
            <div class="col-md-12 d-flex">
                <b-button
                    class="m-auto"
                    variant="info"
                    v-if="photos.length > 0 && !loading"
                    @click="loadMorePhotos"
                >
                    Load more!
                </b-button>
                <b-spinner
                    class="m-auto"
                    type="grow"
                    label="loading"
                    variant="primary"
                    v-if="loading"
                />
            </div>
        </div>
        <div class="text-center text-muted col-md-12 pt-5" v-if="photos.length === 0 && !loading">No photos found :(</div>
    </div>
</template>

<script>
import pixbay from "../modules/pixbay";
import PixbayPhoto from "../components/PixbayPhoto";

export default {
    name: "Favourites",

    components: {
        PixbayPhoto
    },

    computed: {
        auth: function () {
            return this.$store.state.auth;
        },

        authenticated: function () {
            return this.auth.user.token !== null;
        },

        pixbay() {
            return this.$store.state.pixbay || false;
        },

        photos() {
            return this.pixbay.photos || [];
        }
    },

    data: () => ({
        loading: false,
        page: 1,
    }),

    mounted() {
        this.registerModule();
        this.fetchPhotos();
    },

    methods: {
        registerModule() {
            this.$store.registerModule('pixbay', pixbay);
        },

        fetchPhotos() {
            this.loading = true;
            if (!this.auth.user) {
                return;
            }

            this.$store
                .dispatch(
                    'pixbay/fetchPhotosFromDb',
                    {
                        userId: this.auth.user.id,
                        token: this.auth.user.token
                    }
                ).then(() => {this.loading = false});
        },

        loadMorePhotos() {
            this.loading = true;
            this.page    = this.page + 1;

            this.$store
                .dispatch(
                    'pixbay/loadMorePhotosFromDb',
                    {
                        userId: this.auth.user.id,
                        token: this.auth.user.token,
                        page: this.page,
                    }
                ).then(() => {this.loading = false;})
        },

        onDeletePhoto(payload) {
            const photo = this.$refs['photo_' + payload.photoId][0];
            photo.setLoading(true);

            this.$store.dispatch('pixbay/removePhoto', {
                photoId: payload.photoId,
                token: this.auth.user.token,
                userId: this.auth.user.id,
            }).then(() => {
                photo.setLoading(true);
            });
        }
    }

}
</script>

<style scoped>

</style>
