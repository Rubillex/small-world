<template>
    <div class="content">
        <div class="content__top">
            <div class="container">
                <p class="game__name__title">
                    название игры
                </p>
                <p class="game__name__description">
                    Помогите котенку стать инженером-энергетиком!
                </p>
                <div class="button__container">
                    <button class="go" v-on:click="login()">Войти</button>
                    <br>
                    <button v-on:click="register()">Зарегистрироваться</button>
                </div>
                <img src="" alt="а котека то нет">
            </div>
        </div>
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

<style lang="scss" scoped>
.container {
    max-width: 1660px;
}

.content__top {
    height: 840px;
    /*background-image: url("../assets/Frame.png");*/
    background-color: #4C3375;
}

.content {

}
</style>
