<template>
    <div class="question-page">
        <nav-menu FirstLink="К выбору уровня"/>
        <select-title title="тестирование"/>
        <div class="question-page__container">
            <p class="question-page__text">
                Закрепим пройденный материал. За каждый правильный ответ ты получаешь баллы, за неверный - теряешь
                сердечки.
                Будь внимателен!
            </p>
            <div v-if="userLifes > 0" class="life">
                <div class="life__status">
                    <p>Количество попыток:</p>
                    <img class="life__status__img" src="/images/point_base.svg" v-for="n in userLifes">
                </div>
                <div class="question-wrapper">
                    <div class="question-wrapper__content">
                        <span v-html="markDown(data.question)"></span>
                        <div class="cat-question" v-if="needHelp == false">
                            <img class="question-wrapper__content__img" src="/images/question-cat.svg">
                            <div>
                                <div class="cat-question__button" v-for="answer in answers">
                                    <button class="question-wrapper__content__button"
                                            v-on:click="clickAnswer(answer)">{{ answer }}
                                    </button>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            Прикрепите файл
                        </div>
                    </div>
                </div>

                <button class="question-page__button" v-on:click="goToLevels()">Назад к уровням</button>
            </div>
            <div v-else class="no-lifes">
                GG
                <button v-on:click="gameOver()">Гейм Овер</button>
            </div>
        </div>
    </div>
</template>
<script>
import router from "../../router";
import NavMenu from "../partials/Navmenu";
import SelectTitle from "../partials/SelectTitle";

const {marked} = require("marked");
export default {
    name: "QuestionsComponent",
    components: {SelectTitle, NavMenu},
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            levelId: '',
            name: '',
            points: '',
            correct_answers: [],
            incorrect_answers: [],
            needHelp: '',
            answers: [],
            question: '',
            userLifes: '',
        }
    },
    created() {
        this.userLifes = this.data.userLifes;
        this.answers = this.data.answers;
        this.needHelp = this.data.needHelp;
        console.log(this.data);
        console.log(this.needHelp);
    },

    methods: {
        async clickAnswer(answer) {
            if (this.data.correct_answers.includes(answer)) {
                // todo вообще всю логику переделать жесть какая
                await axios.post('/api/test-complited/' + this.data.levelId + '/' + this.data.points)
                    .then()
                    .catch(err => console.log(err));
                if (this.data.correct_answers.length > 1) {
                    this.data.correct_answers.splice(this.data.correct_answers.indexOf(answer), 1);
                }
                this.answers.splice(this.answers.indexOf(answer), 1, 'правильно');

                alert('Правильно!');
            } else {
                this.userLifes = this.userLifes - 1;
                await axios.post('/api/change-lifes/' + this.userLifes)
                    .then()
                    .catch(err => console.log(err));
                alert('Не правильно :(');
            }
        },

        markDown(what) {
            console.log(what);
            return marked(what);
        },

        async goToLevels() {
            await this.$router.push({path: '/levels/'});
            router.go(0);
        },

        async gameOver() {
            await this.$router.push({path: '/levels/'});
            router.go(0);
        },
    }
}
</script>
