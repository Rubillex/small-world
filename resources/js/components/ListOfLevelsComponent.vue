<template>
<div>
    Выбор уровня
    <br>
    <div v-for="(item, index) in data.levelData">
        <div>
            <button v-on:click="goToLevel(index)">{{ item }}</button>
            <br>
        </div>
    </div>
    <button v-on:click="goToProfile()">Верните меня в профиль</button>
</div>
</template>

<script>
import router from "../router";
export default {
    name: "LevelsComponent",
    components: {},
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            levelData: [],
        }
    },

    methods: {
        async goToLevel(levelId){
            await this.$router.push({path: '/level/' + levelId});
            router.go(0);
        },

        async goToProfile() {
            await this.$router.push({path: '/'});
            router.go(0);
        }
    }
}
</script>
