<template>
    <div>
        <input type="text" v-model="email" label="Email" name="email">
        <input type="text" v-model="password" label="Password" name="password">
        <button class="btn btn-primary" @click="signin">Login</button>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data: () => ({
            email: '',
            password: ''
        }),
        methods: {
            signin() {
                console.log(this.email);
                console.log(this.password);
                this.$auth.login({username: this.email, password: this.password})
                    .then(response => {
                        this.$router.push({name: 'welcome'})
                    })
                    .catch(error => {
                        console.log({error})
                        this.error = "Username or password is incorrect"
                    })
            }
        }
    }
</script>

<style scoped>

</style>
