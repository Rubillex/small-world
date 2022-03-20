<template>
<div>
    <div class="page-content">
        <div class="content">
            <div class="content__title">
                GAME OVER
            </div>
            <div class="content__text">
                Упс! Игра окончена, но это лишь повод ещё лучше усвоить пройденный материал. Повторение - мать учения, не сдавайся!
            </div>
            <img v-if="this.data.complexity == 1" class="content__img" src="/images/GG_base.svg" alt="а котека то нет">
            <img v-if="this.data.complexity == 2" class="content__img" src="/images/GG_cool.svg" alt="а котека то нет">
            <img v-if="this.data.complexity == 3" class="content__img" src="/images/GG_cosmo.svg" alt="а котека то нет">
            <div class="content__try-again" @click="gameOver()">
                Попробовать снова
            </div>
        </div>
    </div>
</div>
</template>

<script>
import NavMenu from "./partials/Navmenu";
import router from "../router";
export default {
    name: "GameOverComponent",
    components: { NavMenu },
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            complexity: '',
        }
    },
    created() {
        console.log(this.data);
    },
    methods: {
        async gameOver() {
            await axios.post('/api/change-difficult/-1')
                .catch(err => console.log(err));
            await this.$router.push({path: '/'});
            router.go(0);
        },
    }
}
</script>

<style scoped>

</style>
