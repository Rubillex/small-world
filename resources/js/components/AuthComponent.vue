<template>
<div>
    <button v-on:click="login()">Войти</button>
    <br>
    <button v-on:click="register()">Зарегистрироваться</button>
</div>
</template>

<script>
import router from "../router";

export default {
    name: "AuthComponent",
    components: {},
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    mounted() {
        console.log(this.data)
    },
    methods: {
        async login() {
            await this.$router.push({path: '/login'});
            router.go(0);
        },
        async register() {
            await this.$router.push({path: '/register'});
            router.go(0);
        }
    }
}

</script>

<style scoped>

</style>
