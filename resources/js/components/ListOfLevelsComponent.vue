<template>
    <div class="test-list">
        <nav-menu/>
        <SelectTitle/>
        <div class="wrapper-container">
            <div class="test-select-list__wrapper">
                <template v-for="(item, index) in data.levelData">
                    <div v-on:click="testComplited(item.id) ? '' : goToLevel(item.id)" class="test-select-list__card"
                         :class="testComplited(item.id) ? 'non-complited' : ''">
                        <div class="test-select-list__card-container">
                            <div>
                                <h3 class="test-select-list__card__title" v-html="item.name"/>
                                <p class="test-select-list__card__theory">
                                    Теория
                                </p>
                                <br>
                            </div>
                            <img class="test-select-list__card__img" :src="testComplited(item.id) ? '/images/metka_complited.svg' : '/images/metka 1.svg'" alt="#">
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import router from "../router";
import NavMenu from "./partials/Navmenu";
import SelectTitle from "./partials/SelectTitle";

export default {
    name: "LevelsComponent",
    components: {SelectTitle, NavMenu},
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
        async goToLevel(levelId) {
            await this.$router.push({path: '/level/' + levelId});
            router.go(0);
        },

        async goToProfile() {
            await this.$router.push({path: '/'}).catch(()=>{});
            router.go(0);
        },

        testComplited(testId) {
            return this.data.complited[testId] === 'true';
        }
    }
}
</script>
