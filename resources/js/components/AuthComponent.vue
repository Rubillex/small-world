<template>
    <div class="content">
        <div class="content__top">
            <div class="container">
                <p class="content__top__title">
                    ENERGY
                    CAT GAME
                </p>
                <p class="content__top__description">
                    Помогите котенку стать инженером-энергетиком!
                </p>
                <div class="content__top-button">
                    <button class="content__top-button__register" v-on:click="register()">регистрация</button>
                    <br>
                    <button class="content__top-button__login" v-on:click="login()">вход</button>
                </div>
            </div>
            <img class="content__top__img" src="/images/main_cat.svg" alt="а котека то нет">
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
            <h2 class="content__bottom__title">
                Познакомься с котятами
                <br>
                -инженерами
            </h2>
        </div>
        <div class="content__bottom-level">
            <div class="content__bottom-level-cart">
                <img class="content__bottom-level-cart__img" src="/images/lite.svg" alt="#">
                <h4 class="content__bottom-level-cart__title">
                    Новичок
                </h4>
                <p class="content__bottom-level-cart__description">
                    Заветной мечтой этого малыша была энергетика. Он всегда хотел открыть собственный источник чистой
                    энергии. Вот незадача - этот котик совсем новичок! Но он уверен, что вместе вы сможете изучить
                    что-то новое.
                </p>
            </div>
            <div class="content__bottom-level-cart">
                <img class="content__bottom-level-cart__img" src="/images/medium.svg" alt="#">
                <h4 class="content__bottom-level-cart__title">
                    Продвинутый
                </h4>
                <p class="content__bottom-level-cart__description">
                    У него папа-энергетик, у него мама-энергетик, да он сам у себя энергетик! С этим пушистым шутки
                    плохи, он настроен серьёзно и готов сотрудничать с тобой только в том случае, если ты сам не
                    оплошаешь.
                </p>
            </div>
            <div class="content__bottom-level-cart">
                <img class="content__bottom-level-cart__img" src="/images/hard.svg" alt="#">
                <h4 class="content__bottom-level-cart__title">
                    Эксперт
                </h4>
                <p class="content__bottom-level-cart__description">
                    Этот котенок не с нашей планеты . В его родной галактике он познал уже все области энергетики.
                    Полосатый прибыл на обучение к Землянам на своей собственной ракете! Готов ли ты поделиться с ним
                    своими знаниями?
                </p>
            </div>
        </div>
        <div class="content__bottom">
            <button class="content__bottom__button">
                Я готов к игре!
            </button>
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
