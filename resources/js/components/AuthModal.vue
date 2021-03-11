<template>
    <div>
    <b-modal ref="modal" :title="actionName" :hide-footer="true">
        <register-form v-if="isRegisterAction"/>
        <login-form v-else/>
    </b-modal>
    </div>
</template>

<script>
import RegisterForm from "./Forms/RegisterForm";
import LoginForm from "./Forms/LoginForm";
export default {
    name: "AuthModal",
    components: {LoginForm, RegisterForm},

    data: () => ({
        action : 'register'
    }),

    computed: {
        actionName: function () {
            if (this.isRegisterAction) {
                return 'Register';
            }

            return 'Log in';
        },

        isRegisterAction: function () {
            return this.action === 'register';
        }
    },

    methods: {
        show(action) {
            this.action = action;
            this.$refs.modal.show();
        }
    }
}
</script>

<style scoped>

</style>
