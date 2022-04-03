<template>
<div class="page-content leaderboard">
    <nav-menu></nav-menu>

    <div class="leaderboard-wrapper">
        <span class="leaderboard-title">Таблица лидеров</span>

        <div class="leaderboard__content" v-for="(user, index) in this.data.leaderboard" :key="user.name">
            <div class="leaderboard__circle">
                <div class="leaderboard__circle-text" v-html="index+1">
                </div>
            </div>
            <div class="leaderboard__card">
                <div></div>
                <div class="leaderboard__card-name" v-html="user.name">
                </div>
                <div class="leaderboard__card-points" v-html="user.points">
                </div>
            </div>
        </div>
    </div>
    <img class="leaderboard__cat" src="/images/theory-cat.svg" alt="а котека то нет">
</div>
</template>

<script>
import NavMenu from "./partials/Navmenu";
export default {
    name: "LeaderBoardComponent",
    components: {NavMenu},
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            leaderboard: '',
        }
    }
}
</script>
