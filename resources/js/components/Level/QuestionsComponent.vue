<template>
    <div class="questions-page">
        <h1>Тема : {{data.name}}</h1>
        <span v-html="markDown(data.question)"></span>
        <div v-for="answer in data.answers">
                <button v-on:click="clickAnswer(answer)">{{ answer }}</button>
                <br>
        </div>
        <button v-on:click="goToLevel()">Назад к уровням</button>
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
            name: '',
            correct_answers: [],
            incorrect_answers: [],
            answers: [],
            question: '',
        }
    },
    created() {
        console.log(this.data);
    },

    methods: {
        clickAnswer(answer) {
            if(this.data.correct_answers.includes(answer)){
                alert('Правильно!');
            } else {
                alert('Не правильно :(');
            }
        },

        markDown(what) {
            console.log(what);
            return marked(what);
        },

        async goToLevel(levelId){
            await this.$router.push({path: '/level/' + levelId});
            router.go(0);
        }
    }
}
</script>
