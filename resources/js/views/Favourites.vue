<template>
    <div>
        <div v-if="!authenticated">In order to view this page, please authenticate.</div>
    </div>
</template>

<script>
export default {
    name: "Favourites",

    computed: {
        auth: function () {
            return this.$store.state.auth;
        },

        authenticated: function () {
            return this.auth.user.token !== null;
        }
    }

}
</script>

<style scoped>

</style>
