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
                    <img class="life__status__img" v-if="complexity == 1" src="/images/point_base.svg" v-for="n in userLifes" alt=".">
                    <img class="life__status__img" v-if="complexity == 2" src="/images/point_cool.svg" v-for="n in userLifes" alt=".">
                    <img class="life__status__img" v-if="complexity == 3" src="/images/point_cosmo.svg" v-for="n in userLifes" alt=".">
                </div>
                <div class="question-wrapper" v-if="result === false">
                    <div class="question-wrapper__content">
                        <span v-html="markDown(data.question)"></span>
                        <div class="cat-question" v-if="needHelp == false">
                            <img class="question-wrapper__content__img" v-if="complexity == 1" src="/images/question-cat.svg" alt=".">
                            <img class="question-wrapper__content__img" v-if="complexity == 2" src="/images/question_cool.svg" alt=".">
                            <img class="question-wrapper__content__img" v-if="complexity == 3" src="/images/question_cosmo.svg" alt=".">
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

                <div class="question-wrapper-result" v-if="result === true && userLifes > 0">
                    <div class="image" v-if="complexity == 1">
                        <img class="result-img"
                             v-if="answer_result"
                             src="/images/happy_base.svg" alt="happy_base.svg">
                        <img class="result-img"
                             v-else
                             src="/images/sad_base.svg" alt="sad_base.svg">
                    </div>

                    <div class="image" v-if="complexity == 2">
                        <img class="result-img"
                             v-if="answer_result"
                             src="/images/happy_cool.svg" alt="happy_cool.svg">
                        <img class="result-img"
                             v-else
                             src="/images/sad_cool.svg" alt="sad_cool.svg">
                    </div>

                    <img class="result-img"
                         v-if="complexity == 3"
                         src="/images/happy_cosmo.svg" alt="happy_cosmo.svg">
                    <div class="result-card__content">
                        <span class="result-card__title"> {{ title }} </span>
                        <div class="result-card__points">
                            <span class="points-text"> Твои баллы: </span>
                            <span class="points-points"> {{ points }} </span>
                        </div>
                        <span class="result-card__add-points" v-if="answer_result">
                            {{ add_points }} </span>
                        <button class="result-gameover" v-else @click="refresh()">Попробовать снова</button>
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
            complexity: '',
            checked_answers: [],
            add_points: '',
            result: false,
            title: '',
            answer_result: false,
        }
    },
    created() {
        this.userLifes = this.data.userLifes;
        this.answers = this.data.answers;
        this.needHelp = this.data.needHelp;
        this.correct_answers = this.data.correct_answers;
        this.complexity = this.data.complexity;
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
                    this.result = true;
                    if (response.data.result){
                        this.answer_result = true;
                        this.title = 'ОТВЕТ ВЕРНЫЙ!';
                        this.userLifes = response.data.userLifes;
                        this.points = response.data.points.toFixed(1);
                        switch (response.data.add_points){
                            case 1:
                                this.data.add_points = '+ 1 балл';
                                break;
                            case 1.2:
                                this.data.add_points = '+ 1.2 балла';
                                break;
                            case 1.5:
                                this.data.add_points = '+ 1.5 балла';
                                break;
                        }
                    } else {
                        this.answer_result = false;
                        this.title = 'ОТВЕТ НЕВЕРНЫЙ!';
                        this.userLifes = response.data.userLifes;
                        if(this.userLifes <= 0){
                            location.reload();
                        }
                        this.points = response.data.points.toFixed(1);
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

        refresh() {
            location.reload();
        },

        async goToLevels() {
            await this.$router.push({path: '/levels/'});
            router.go(0);
        },
    }
}
</script>
