<template>
    <div>
        <h1>{{ data.name }}</h1>
        <br>
        <div  v-html="markDown(data.brefing)"></div>
        <button v-on:click="goAnswers(data.levelId)">К вопросам</button>
    </div>
</template>

<script>
const {marked} = require("marked");
import router from "../../router";
export default {
    name: "Level",
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            levelId: '',
            brefing: '',
            name: '',
            needHelp: '',
            points: '',
            levelData: [],
        }
    },

    methods: {
        markDown(what) {
            return marked(what);
        },

        async goAnswers(levelId) {
            await this.$router.push({path: '/level/' + levelId + '/answer/'});
            router.go(0);
        },
    }
}
</script>
