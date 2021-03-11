<template>
    <b-navbar toggleable="lg" type="dark" variant="dark" sticky>
        <b-navbar-brand href="#">Pixbay Gallery</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="navbar-center">
                <b-form-input size="sm" placeholder="Search"></b-form-input>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto">
                <b-nav-item-dropdown right>
                    <template #button-content>
                        <em>User</em>
                    </template>
                    <b-dropdown-item href="#" @click="$emit('loginRequest')">Log In</b-dropdown-item>
                    <b-dropdown-item href="#" @click="$emit('registerRequest')">Register</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
export default {
    name: "AppHeader",
}
</script>

<style scoped>
    .navbar-center {
        width: 80%;
        margin: auto;
    }
</style>
