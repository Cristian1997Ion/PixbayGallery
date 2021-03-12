<template>
    <b-navbar toggleable="lg" type="dark" variant="dark" sticky>
        <b-navbar-brand href="/web">Pixbay Gallery</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="navbar-center">
                <b-form-input size="sm" placeholder="Search" @change="search" :value="$route.query.q"/>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto">
                <b-nav-item-dropdown right>
                    <template #button-content>
                        <em>
                            <span v-if="authenticated">
                                {{username}}
                            </span>
                            <span v-else>
                                Hello
                            </span>
                        </em>
                    </template>
                    <div v-if="authenticated">
                        <b-dropdown-item href="#">
                            <router-link :to="{name: 'favourites'}">Favourites</router-link>
                        </b-dropdown-item>
                        <b-dropdown-item href="#" @click="$emit('signOut')">Sign Out</b-dropdown-item>
                    </div>
                    <div v-else>
                        <b-dropdown-item href="#" @click="$emit('loginRequest')">Log In</b-dropdown-item>
                        <b-dropdown-item href="#" @click="$emit('registerRequest')">Register</b-dropdown-item>
                    </div>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
export default {
    name: "AppHeader",

    computed: {
        auth: function () {
            return this.$store.state.auth;
        },

        authenticated: function() {
            return this.auth.user.token !== null;
        },

        username: function () {
            return this.auth.user.name;
        }
    },

    methods: {
        search(searchTerm) {
            location.href = '/web?q=' + searchTerm
        }
    }
}
</script>

<style scoped>
    .navbar-center {
        width: 80%;
        margin: auto;
    }
</style>
