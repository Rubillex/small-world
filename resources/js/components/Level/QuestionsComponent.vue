<template>
    <div class="questions-page">
        <div v-if="userLifes > 0" class="lifes">
        <p v-for="n in userLifes">Я жизнь</p>
        <h1>Тема : {{data.name}}</h1>
        <span v-html="markDown(data.question)"></span>
        <div v-for="answer in data.answers">
                <button v-on:click="clickAnswer(answer)">{{ answer }}</button>
                <br>
        </div>
        <button v-on:click="goToLevels()">Назад к уровням</button>
        </div>
        <div  v-else class="no-lifes">
            GG
        <button v-on:click="gameOver()">Гейм Овер</button>
        </div>
    </div>
</template>

<script>
import router from "../../router";
const {marked} = require("marked");
export default {
    name: "QuestionsComponent",
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            levelId: '',
            name: '',
            correct_answers: [],
            incorrect_answers: [],
            answers: [],
            question: '',
            userLifes: '',
        }
    },
    created() {
        this.userLifes = this.data.userLifes;
        console.log(this.data);
    },

    methods: {
        async clickAnswer(answer) {
            if (this.data.correct_answers.includes(answer)) {
                await axios.post('/api/test-comlpited/' + this.data.levelId)
                    .then()
                    .catch(err => console.log(err));
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
