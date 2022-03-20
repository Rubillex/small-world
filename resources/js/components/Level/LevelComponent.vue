<template>
    <div>
        <nav-menu first-link="К выбору уровня"/>
        <select-title title="Теория"/>
        <div class="level-content">
            <div class="level-content-container">
                <h1 class="level-content__title">{{ data.name }}</h1>
                <br>
                 <img src="/images/Line.svg" alt="#">
                <div class="level-content__text" v-html="markDown(data.brefing)">
                </div>
            </div>
        </div>
        <button v-on:click="goAnswers(data.levelId)">К вопросам</button>
    </div>
</template>

<script>
import NavMenu from "../partials/Navmenu";

const {marked} = require("marked");
import router from "../../router";
import SelectTitle from "../partials/SelectTitle";

export default {
    name: "Level",
    components: {SelectTitle, NavMenu},
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
