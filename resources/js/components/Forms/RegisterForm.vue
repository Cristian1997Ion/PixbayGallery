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
        <b-button variant="primary float-right">Register</b-button>
    </b-form>
</template>

<script>
export default {
    name: "RegisterForm",

    data: () => ({
        form: {
            email: '',
            name: '',
            password: '',
        },
    }),
}
</script>

<style scoped>

</style>
