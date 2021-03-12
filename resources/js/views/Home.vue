<template>
    <div>
        <div class="row pt-3" v-if="cacheKey && remainingCacheTime">
            <div class="col-md-12 text-center text-info">Photos cached with '{{cacheKey}}' & cache expires in {{remainingCacheTime}}</div>
        </div>
        <div class="row pt-3">
            <pixbay-photo
                v-if="photos.length > 0"
                v-for="photo in photos"
                v-bind:key="photo.id"
                :photo="photo"
                :ref="'photo_' + photo.id"
                class="mb-2 col-md-4"
                @storePhoto="onStorePhoto"
            />
            <div class="text-center text-muted col-md-12 pt-5" v-if="photos.length === 0 && !loading">No photos found :(</div>
        </div>
        <div class="row pt-3 mb-3">
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
    </div>
</template>

<script>
import pixbay from "../modules/pixbay";
import PixbayPhoto from "../components/PixbayPhoto";
export default {
    name: "Home",
    components: {PixbayPhoto},

    computed: {
        auth() {
            return this.$store.state.auth;
        },

        pixbay() {
            return this.$store.state.pixbay || false;
        },

        photos() {
            return this.pixbay.photos || [];
        },

        cacheKey() {
            return this.pixbay.cacheKey || false;
        },

        remainingCacheTime() {
            return this.pixbay.remainingCacheTime || false;
        }
    },

    data: () => ({
       page: 1,
       loading: false,
    }),

    mounted() {
        this.registerModule();
        this.fetchPhotos();
    },

    methods: {
        registerModule() {
            if(this.$store.hasModule('pixbay')) return;

            this.$store.registerModule('pixbay', pixbay);
        },

        fetchPhotos() {
            this.loading = true;
            this.$store
                .dispatch('pixbay/fetchPhotos', {q: this.$route.query.q})
                .then(() => {this.loading = false;});
        },

        loadMorePhotos() {
            this.loading = true;
            this.page    = this.page + 1;

            this.$store
                .dispatch('pixbay/loadMorePhotos', {q: this.$route.query.q, page: this.page})
                .then(() => {
                    this.loading = false;
                })
            ;
        },

        onStorePhoto(payload) {
            if (!this.auth.user || !this.auth.user.token) {
                alert('Please authenticate.');
                return;
            }

            const photo = this.$refs['photo_' + payload.photoId][0];
            photo.setLoading(true);


            this.$store.dispatch('pixbay/storePhoto', {
                userId: this.auth.user.id,
                token: this.auth.user.token,
                photoUrl: payload.photoUrl,
                photoId: payload.photoId,
            }).then(() => {
                alert(this.pixbay.storeMessage);
                photo.setLoading(false);
            })
        }
    }
}
</script>

<style scoped>

</style>
