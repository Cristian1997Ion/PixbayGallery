<template>
    <b-form>
        <b-form-group
            id="input-group-1"
            label="Email address:"
            label-for="input-1"
        >
            <b-form-input
                id="input-1"
                v-model="form.email"
                type="email"
                placeholder="Enter email"
                required
            />
            <span class="text-danger">{{emailError}}</span>
        </b-form-group>
        <b-form-group
            id="input-group-1"
            label="Password:"
            label-for="input-1"
        >
            <b-form-input
                id="input-1"
                v-model="form.password"
                type="password"
                placeholder="Enter password"
                required
            />
        </b-form-group>
        <b-button variant="primary float-right" @click="submit" :disabled="submitting">Log in</b-button>
    </b-form>
</template>

<script>
export default {
    name: "LoginForm",

    data: () => ({
        form: {
            email: '',
            password: '',
        },
        submitting: false,
    }),

    computed: {
        auth: function () {
            return this.$store.state.auth;
        },

        errors: function () {
            return this.auth.errors || null;
        },


        emailError: function () {
            return (
                this.errors != null &&
                this.errors.email != null &&
                this.errors.email[0] !== null
            ) ? this.errors.email[0] : '';
        },
    },

    methods: {
        submit() {
            this.submitting = true;
            this.$store.dispatch('auth/login', {
                email: this.form.email,
                password: this.form.password
            }).then(() => {
                if (this.errors) {
                    this.submitting = false;
                    return;
                }

                location.reload();
            })
        }
    }
}
</script>

<style scoped>

</style>
