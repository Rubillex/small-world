<template>
    <div>
        <div class="content">
            <nav-menu></nav-menu>
            <div class="content__card__column__right__leader-board-content" v-for="(user, index) in this.data.leaderboard" :key="user.name">
                <div class="content__card__column__right__leader-board-content__circle">
                    <div class="content__card__column__right__leader-board-content__circle__text" v-html="index+1">
                    </div>
                </div>
                <div class="content__card__column__right__leader-board-content__card">
                    <div></div>
                    <div class="content__card__column__right__leader-board-content__card__name" v-html="user.name">
                    </div>
                    <div class="content__card__column__right__leader-board-content__card__points" v-html="user.points">
                    </div>
                </div>
            </div>
        </div>
        <img class="img" src="/images/theory-cat.svg" alt="а котека то нет">
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
    },
    methods: {

    }
}
</script>

<style>

.content {
    display:flex;
    flex-direction: column;
    margin-bottom: 30px;
}

.content__card__column__right__leader-board-content {
    display: flex;
    flex-flow: row nowrap;
    width: 65%;
    margin-bottom: 8px;
    align-items: center;
    justify-content: center;
    align-self:center;
}

.content__card__column__right__leader-board-content__circle{
    background: #E2505E;
    border: 5px solid #FFFFFF;
    border-radius: 50px;
    height: 3vw;
    width: 3vw;
    display: flex;
    z-index: 1;
}

.content__card__column__right__leader-board-content__circle__text{
    align-self: center;
    flex-grow: 1;
    font-style: normal;
    font-weight: 700;
    font-size: 24px;
    line-height: 40px;
    text-align: center;
    color: #000000;
}

.content__card__column__right__leader-board-content__card{
    padding: 6px;
    background-color: white;
    border-radius: 16px;
    margin-left: -30px;
    color: black;
    flex-grow: 1;
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
}

.content__card__column__right__leader-board-content__card__name{
    text-align: center;
    font-style: normal;
    font-weight: 600;
    font-size: 20px;
    line-height: 24px;

    color: #000000
}

.content__card__column__right__leader-board-content__card__points{
    margin-right: 20px;
    font-style: normal;
    font-weight: 600;
    font-size: 20px;
    line-height: 24px;

    color: #000000
}

.img {
    width: 15%;
    margin-top: -20px;
    margin-left: 70px;
}
</style>
