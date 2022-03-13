<template>
    <div>
        <h1>{{ name }}</h1>
        <br>
        <div  v-html="markDown(brefing)"></div>
        <span v-html="markDown(question)"></span>
        <template v-for="answer in answers">
            <div>
                <button v-on:click="clickAnswer(answer)">{{ answer }}</button>
                <br>
            </div>
        </template>
    </div>
</template>

<script>
const {marked} = require("marked");
export default {
    name: "Level",
    components: {},
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            levelId: '',
            brefing: '',
            correct_answers: [],
            incorrect_answers: [],
            answers: [],
            name: '',
            needHelp: '',
            points: '',
            question: '',
            levelData: [],
        }
    },
    created() {
        this.getData();
    },

    methods: {
        async getData() {
            await axios.post('/api/getlevelData/' + this.data.levelId)
                .then(response => {
                    if (!response.data.error) {
                        let answer = JSON.parse(response.data.answer);
                        this.levelId = answer.id;
                        this.brefing = answer.brefing;
                        this.correct_answers = JSON.parse(answer.correct_answers);
                        this.incorrect_answers = JSON.parse(answer.incorrect_answers);
                        this.name = answer.name;
                        this.needHelp = answer.needHelp;
                        this.points = answer.points;
                        this.question = answer.question;
                        this.answers = this.correct_answers.concat(this.incorrect_answers);
                        this.shuffle(this.answers);
                    } else {
                        console.log(response.data.error);
                    }
                })
                .catch(err => console.log(err));
        },
        shuffle(array) {
            let currentIndex = array.length, temporaryValue, randomIndex;
            while (0 !== currentIndex) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;
                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }

            return array;
        },

        clickAnswer(answer) {
            if(this.correct_answers.includes(answer)){
                alert('Правильно!');
            } else {
                alert('Не правильно :(');
            }
        },

        markDown(what) {
            console.log(what);
            return marked(what);
        },
    }
}
</script>
