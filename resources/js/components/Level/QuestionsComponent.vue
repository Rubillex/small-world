<template>
    <div class="question-page">
        <nav-menu FirstLink="К выбору уровня"/>
        <select-title title="тестирование"/>
        <div class="page-content">
        <div class="question-page__container">
            <p class="question-page__text">
                Закрепим пройденный материал. За каждый правильно решенный ты получаешь баллы, за ошибку - теряешь
                сердечко. Причем сразу. <b>Когда считаешь, что выбрал все нужные варианты ответа - нажми кнопку готово!</b>
                Будь внимателен!
            </p>
            <div class="life-wrapper">
            <div v-if="userLifes > 0" class="life">
                <div class="life__status">
                    <p>Количество попыток:</p>
                    <img class="life__status__img" src="/images/point_base.svg" v-for="n in userLifes" alt=".">
                </div>
                <div class="question-wrapper">
                    <div class="question-wrapper__content">
                        <span v-html="markDown(data.question)"></span>
                        <div class="cat-question" v-if="needHelp == false">
                            <img class="question-wrapper__content__img" src="/images/question-cat.svg" alt=".">
                            <div>
                                <div class="cat-question__button" v-for="answer in answers">
                                    <button class="question-wrapper__content__button"
                                            v-on:click="clickAnswer(answer, $event.target)">{{ answer }}
                                    </button>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <form @submit.prevent="submitFile">
                                <input type="file" @change="handleFileUpload()"/>
                                <button>Подтвердить</button>
                            </form>
                        </div>
                        <button class="ready-button" v-on:click="nextButton()">Готово</button>
                    </div>
                </div>

                <button class="question-page__button" v-on:click="goToLevels()">Назад к уровням</button>
            </div>
            <div v-else class="no-lifes">
<!--                GG-->
<!--                <button v-on:click="gameOver()">Гейм Овер</button>-->
                <game-over-component :data="data"></game-over-component>
            </div>
            </div>

        </div>
        </div>
    </div>
</template>
<script>
import router from "../../router";
import NavMenu from "../partials/Navmenu";
import SelectTitle from "../partials/SelectTitle";
import GameOverComponent from "../GameOverComponent";
const {marked} = require("marked");
export default {
    name: "QuestionsComponent",
    components: {SelectTitle, NavMenu, GameOverComponent},
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
            file: '',
            wp: false,
            error: false,
            complexity: '',
        }
    },
    created() {
        this.userLifes = this.data.userLifes;
        this.answers = this.data.answers;
        this.needHelp = this.data.needHelp;
    },

    methods: {
        async clickAnswer(answer, event) {
            if (event.classList.contains('checked')) return;

            event.classList.add('checked');
            if (this.data.correct_answers.includes(answer)) {
                if (this.data.correct_answers.length >= 1) {
                    this.data.correct_answers.splice(this.data.correct_answers.indexOf(answer), 1);
                }
                if (this.error == false) this.wp = true;
            } else {
                this.userLifes = this.userLifes - 1;
                await axios.post('/api/change-lifes/' + this.userLifes)
                    .then()
                    .catch(err => console.log(err));
                this.wp = false;
                this.error = true;
            }
        },

        handleFileUpload() {
            this.file = event.target.files[0];
            console.log(this.file);
        },
        async submitFile() {
            let formData = new FormData;
            console.log(this.file);
            formData.set('image', this.file);
            console.log(this.data.levelId);
            await axios.post('/api/upload-file/' + this.data.levelId, formData)
                .then()
                .catch(err => console.log(err));
        },

        markDown(what) {
            console.log(what);
            return marked(what);
        },

        async nextButton() {
            if(this.needHelp == true){
                await axios.post('/api/test-complited/' + this.data.levelId + '/' + this.data.points)
                    .then()
                    .catch(err => console.log(err));
                await this.$router.push({path: '/levels/'});
                router.go(0);
            } else
            if (this.wp == true) {
                if (this.data.correct_answers.length < 1){
                    await axios.post('/api/test-complited/' + this.data.levelId + '/' + this.data.points)
                        .then()
                        .catch(err => console.log(err));
                }
                await this.$router.push({path: '/levels/'});
                router.go(0);
            } else {
                if (this.error == true){
                    await this.$router.push({path: '/levels/'});
                    router.go(0);
                } else {
                    alert('нет ответа');
                }
            }
        },

        async gameOver() {
            await axios.post('/api/change-difficult/-1')
                .catch(err => console.log(err));
            await this.$router.push({path: '/'});
            router.go(0);
        },

        async goToLevels() {
            await this.$router.push({path: '/levels/'});
            router.go(0);
        },
    }
}
</script>
