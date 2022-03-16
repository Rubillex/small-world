<template>
    <div class="content">
        <div class="content__top">
            <div class="container">
                <p class="content__top__title">
                    название игры
                </p>
                <p class="content__top__description">
                    Помогите котенку стать инженером-энергетиком!
                </p>
                <div class="content__button">
                    <button class="content__button__login" v-on:click="login()">Войти</button>
                    <br>
                    <button class="content__button__register" v-on:click="register()">Зарегистрироваться</button>
                </div>
                <img class="content__top__img" src="/images/main_cat.svg" alt="а котека то нет">
            </div>
        </div>
        <div class="content__mid">
            <h2 class="content__mid__title">
                Привет, студент!
            </h2>
            <p class="content__mid__description">
                Если ты здесь, значит из тебя в будущем может получится отличный инженер энергетик. Возможно, ты ещё
                не так много знаешь об этой науке, но наши котята-инженеры хотят немного поднять твой уровень.
            </p>
            <p class="content__mid__description">
                Сейчас ты получишь доступ к секретной системе обучения студентов-энергетиков. Эта система воспитала
                уже не одно поколение настоящих профессионалов. А чтобы тебе не было скучно, мы дадим тебе пушистого
                товарища.
            </p>
            <p class="content__mid__description">
                Вместе веселее!
            </p>
        </div>
        <div class="content__bottom">

        </div>
        <div class="content__bottom">

        </div>
        <div class="content__bottom">

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

<style scoped>

</style>
