<template>
    <div class="template-page">
        <nav-menu></nav-menu>
            <div v-if="data.userDifficult === '-1'" class="choose-difficult">
                <complexety-component></complexety-component>
            </div>
            <div v-else class="go-to-game">
                <div class="page-content">
                    <h2>Страртовая</h2>
                    <button v-on:click="newGame()">Пошли играть!</button>
                </div>
            </div>
    </div>

</template>

<script>
import router from "../router";
import ComplexetyComponent from "./ComplexityComponent";
import NavMenu from "./partials/Navmenu";

export default {
    name: "TemplateComponent",
    components: {NavMenu, ComplexetyComponent},
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            pageData: 0,
            userName: '',
            gameId: '',
            userDifficult: '',
            newValue: 0,
        }
    },
    mounted() {
        console.log(this.data)
    },
    methods: {
        async newGame() {
            await this.$router.push({path: '/levels/'});
            router.go(0);
        },
    }
}
</script>
