<template>
    <div class="test-list">
        <nav-menu/>
        <div class="test-select">
            <h2 class="test-select__title">Выбор уровня</h2>
            <img class="test-select__img" src="/images/main_cat.svg" alt="а котека то нет">
        </div>
        <div class="wrapper-container">
            <div class="test-select-list__wrapper">
                <template v-for="(item, index) in data.levelData">
                    <div class="test-select-list__card">
                        <div class="test-select-list__card-container">
                            <div>
                                <h3 class="test-select-list__card__title">
                                    {{ item }}
                                </h3>
                                <button class="test-select-list__card__theory" v-on:click="goToLevel(index)">
                                    Теория
                                </button>
                                <br>
                            </div>
                            <img class="test-select-list__card__img" src="/images/metka 1.svg" alt="#">
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

export default {
    name: "LevelsComponent",
    components: { NavMenu },
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
            await this.$router.push({path: '/level/' + levelId}).catch(()=>{});
            router.go(0);
        },

        async goToProfile() {
            await this.$router.push({path: '/'}).catch(()=>{});
            router.go(0);
        }
    }
}
</script>
