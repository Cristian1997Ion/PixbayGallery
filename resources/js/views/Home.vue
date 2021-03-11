<template>
    <div>
        <div class="row pt-3">
            <pixbay-photo
                v-for="photo in photos"
                v-bind:key="photo.id"
                :image="photo"
                class="mb-2 col-md-4"
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
        photoCount: function() {
            return this.$store.state.pixbay.photoCount || 0;
        },

        photos() {
            return this.$store.state.pixbay.photos || [];
        }
    },

    mounted() {
        this.registerModule();
        this.fetchPhotos();
    },

    methods: {
        registerModule() {
            this.$store.registerModule('pixbay', pixbay);
        },

        fetchPhotos() {
            this.$store.dispatch('pixbay/fetchPhotos', {});
        }
    }
}
</script>

<style scoped>

</style>
