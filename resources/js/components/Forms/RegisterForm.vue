<template>
    <b-form>
        <b-form-group
            id="input-group-1"
            label="Email address:"
            label-for="input-1"
            description="We'll never share your email with anyone else."
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
            label="Name:"
            label-for="input-1"
        >
            <b-form-input
                id="input-1"
                v-model="form.name"
                type="text"
                placeholder="Enter name"
                required
            />
            <span class="text-danger">{{nameError}}</span>
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
            <span class="text-danger">{{passwordError}}</span>
        </b-form-group>
        <b-button variant="primary float-right" @click="submit" :disabled="submitting">Register</b-button>
    </b-form>
</template>

<script>
export default {
    name: "RegisterForm",

    data: () => ({
        submitting: false,
        form: {
            email: '',
            name: '',
            password: '',
        },
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

        nameError: function () {
            return (
                this.errors != null &&
                this.errors.name != null &&
                this.errors.name[0] !== null
            ) ? this.errors.name[0] : '';
        },

        passwordError: function () {
            return (
                this.errors != null &&
                this.errors.password != null &&
                this.errors.password[0] !== null
            ) ? this.errors.password[0] : '';
        }
    },

    methods: {
        submit() {
            this.submitting = true;
            this.$store.dispatch('auth/register', {
                name: this.form.name,
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
