<template>
    <div>
        <app-header
            @registerRequest="openModal('register')"
            @loginRequest="openModal('login')"
            @signOut="onSignOut"
        />

        <auth-modal ref="auth"/>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import AppHeader from "../components/AppHeader";
import AuthModal from "../components/AuthModal";

export default {
    components: {AuthModal, AppHeader},

    methods: {
        openModal(action) {
            this.$refs.auth.show(action);
        },

        onSignOut() {
            this.$store.dispatch('auth/signOut').then(() => {
                console.log('sign-out');
                location.reload();
            });
        }
    }
}
</script>
