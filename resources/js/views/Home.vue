<template>
    <div>
        <div class="row pt-3">
            <pixbay-photo
                v-for="photo in photos"
                v-bind:key="photo.id"
                :photo="photo"
                class="mb-2 col-md-4"
                @storePhoto="onStorePhoto"
            />
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
            this.$store.dispatch('pixbay/fetchPhotos', {q: this.$route.query.q});
        },

        onStorePhoto(payload) {
            if (!this.auth.user || !this.auth.user.token) {
                alert('Please authenticate.');
                return;
            }

            this.$store.dispatch('pixbay/storePhoto', {
                userId: this.auth.user.id,
                token: this.auth.user.token,
                photoUrl: payload.photoUrl,
                photoId: payload.photoId,
            }).then(() => {
                alert(this.pixbay.storeMessage);
            })
        }
    }
}
</script>

<style scoped>

</style>
