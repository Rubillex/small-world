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
                                <div v-if="this.correct_answers.length > 1">
                                    <div v-for="answer in answers"  class="form-check">
                                        <label class="answer">
                                            <input class="answer-checkbox form-check-input" type="checkbox" v-bind:value="answer" v-model="checked_answers">
                                            <span class="answer-text form-check-label">{{ answer }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div v-if="this.correct_answers.length == 1">
                                    <div v-for="answer in answers" class="answer ">

                                        <label class="answer">
                                            <input class="answer-radio form-check-input" type="radio" v-bind:value="answer" v-model="checked_answers">
                                            <span class="answer-text form-check-label">{{ answer }}</span>
                                        </label>
                                    </div>
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
            checked_answers: [],
            add_points: '',
        }
    },
    created() {
        this.userLifes = this.data.userLifes;
        this.answers = this.data.answers;
        this.needHelp = this.data.needHelp;
        this.correct_answers = this.data.correct_answers;
    },

    methods: {
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
            if (typeof this.checked_answers === "string") {
                this.checked_answers = [this.checked_answers];
            }
            await axios.post('/api/test-complited/' + this.data.levelId + '/' + this.data.points + '/' + JSON.stringify(this.checked_answers))
                .then(response => {
                    console.log(response.data);
                    if (response.data.result){
                        this.data.userLifes = response.data.userLifes;
                        this.data.points = response.data.points;
                        this.data.add_points = response.data.add_points;
                        alert(response.data.userLifes + ' ' + response.data.points + ' ' + response.data.add_points);
                    } else {
                        this.data.userLifes = response.data.userLifes;
                        this.data.points = response.data.points;
                        alert(response.data.userLifes + ' ' + response.data.points);
                    }
                })
                .catch(err => console.log(err));
            // await this.$router.push({path: '/levels/'});
            // router.go(0);
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
