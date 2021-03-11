<template>
    <div>
        <app-header
            @registerRequest="openModal('register')"
            @loginRequest="openModal('login')"
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
            console.log(this.$refs);
            this.$refs['auth'].show(action);
        }
    }
}
</script>
