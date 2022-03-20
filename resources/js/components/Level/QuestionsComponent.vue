<template>
    <div class="questions-page">
        <div v-if="userLifes > 0" class="lifes">
        <p v-for="n in userLifes">Я жизнь</p>
        <h1>Тема : {{data.name}}</h1>
        <span v-html="markDown(data.question)"></span>
            <div v-if="needHelp == false">
                <div v-for="answer in answers">
                    <button v-on:click="clickAnswer(answer)">{{ answer }}</button>
                    <br>
                </div>
            </div>
            <div v-else>
                <div>


                    <label>
                        <input type="file" id="file" name="file" ref="file" v-on:change="handleFileUpload()"/>
                    </label>
                    <button v-on:click="submitFile()">Submit</button>
                </div>
            </div>
            <button v-on:click="nextButton()">Готово</button>
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
            console.log(this.data.correct_answers);
        },

        handleFileUpload() {
            this.file = this.$refs.file.files[0];
        },
        async submitFile() {
            let formData = new FormData();
            formData.append('file', this.file);
            console.log(formData);
            await axios.post('/api/upload-file/' + formData)
                .then()
                .catch(err => console.log(err));
        },

        markDown(what) {
            console.log(what);
            return marked(what);
        },

        async nextButton() {
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
    }
}
</script>
