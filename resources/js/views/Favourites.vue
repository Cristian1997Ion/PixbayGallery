<template>
    <div>
        <div v-if="!authenticated">In order to view this page, please authenticate.</div>
        <div class="row pt-3" v-else>
            <pixbay-photo
                v-for="photo in photos"
                v-bind:key="photo.id"
                :photo="photo"
                class="mb-2 col-md-4"
                :show-add-to-favourites="false"
                :show-author="false"
                @deletePhoto="onDeletePhoto"
            />
        </div>
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

    mounted() {
        this.registerModule();
        this.fetchPhotos();
    },

    methods: {
        registerModule() {
            //if(this.$store.hasModule('pixbay')) return;

            this.$store.registerModule('pixbay', pixbay);
        },

        fetchPhotos() {
            if (!this.auth.user) {
                return;
            }

            this.$store.dispatch('pixbay/fetchPhotosFromDb', {
                userId: this.auth.user.id,
                token: this.auth.user.token,
            });
        },

        onDeletePhoto(payload) {
            this.$store.dispatch('pixbay/removePhoto', {
                photoId: payload.photoId,
                token: this.auth.user.token,
                userId: this.auth.user.id,
            });
        }
    }

}
</script>

<style scoped>

</style>
