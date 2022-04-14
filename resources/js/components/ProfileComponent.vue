<template>
    <div class="page-content">
        <div class="content">
            <div class="content__top">
                <div class="content__top-button" @click="goToLevels()">
                    К выбору уровней
                </div>
                <div class="content__top-button" @click="logout()">
                    Выйти
                </div>
            </div>
            <div class="content__card">
                <p class="content__card__name" v-html="this.data.currentUserName">
                </p>
                <div class="content__card__column">
                    <div class="content__card__column__left">
                        <img class="content__card__column__left__img" v-if="complexity == 1" src="/images/leader_cat.svg" alt="а котека то нет">
                        <img class="content__card__column__left__img" v-if="complexity == 2" src="/images/comp_cool.svg" alt="а котека то нет">
                        <img class="content__card__column__left__img" v-if="complexity == 3" src="/images/comp_cosmo.svg" alt="а котека то нет">
                        <div class="content__card__column__left__userLifes">
                            <img class="content__card__column__left__userLifes__img"
                                 src="/images/point_base.svg" alt="а хп нет :("
                                 v-if="complexity == 1"
                                 v-for="life in this.data.currentUserLifes">
                            <img class="content__card__column__left__userLifes__img"
                                 src="/images/point_cool.svg" alt="а хп нет :("
                                 v-if="complexity == 2"
                                 v-for="life in this.data.currentUserLifes">
                            <img class="content__card__column__left__userLifes__img"
                                 src="/images/point_cosmo.svg" alt="а хп нет :("
                                 v-if="complexity == 3"
                                 v-for="life in this.data.currentUserLifes">
                        </div>
                    </div>
                    <div class="content__card__column__right">
                        <p class="content__card__column__right__points-title">
                            Мой текущий счет
                        </p>
                        <p class="content__card__column__right__points-num" v-html="this.data.currentUserPoints"></p>
                        <div class="title-popover">
                            <p class="content__card__column__right__leader-title"  v-on:click="openPopup()">
                                Таблица лидеров
                            </p>
                            <p v-popover:foo class="leaderboard-popover">?</p>
                        </div>
                        <div class="content__card__column__right__leader-board">
                            <div class="content__card__column__right__leader-board-content" v-for="(user, index) in this.data.usersList" :key="user.name">
                                <div v-if="user.id != 1" class="content__card__column__right__leader-board-content__circle">
                                    <div class="content__card__column__right__leader-board-content__circle__text" v-html="index+1">
                                    </div>
                                </div>
                                <div v-if="user.id != 1" class="content__card__column__right__leader-board-content__card">
                                    <div></div>
                                    <div class="content__card__column__right__leader-board-content__card__name" v-html="user.name">
                                    </div>
                                    <div class="content__card__column__right__leader-board-content__card__points" v-html="user.points">
                                    </div>
                                </div>
                            </div>
                            <div class="content__card__column__right__leader-board-content" v-if="this.data.userInTop === false">
                                <div class="content__card__column__right__leader-board-content__circle">
                                    <div class="content__card__column__right__leader-board-content__circle__text" v-html="this.data.currentUserIndex">
                                    </div>
                                </div>
                                <div class="content__card__column__right__leader-board-content__card">
                                    <div></div>
                                    <div class="content__card__column__right__leader-board-content__card__name" v-html="this.data.currentUserName">
                                    </div>
                                    <div class="content__card__column__right__leader-board-content__card__points" v-html="this.data.currentUserPoints">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <vue-modaltor
                :visible="open"
                :animation-panel="'modal-slide-bottom'"
                >
                <template #header>
                    <!--    add your custom header     -->
                    <div class="modal-header-leaderboard">
                        <div class="modal-title">
                            Таблица лидеров
                        </div>
                    </div>
                </template>
                <template #body>
                    <div class="modal-content-leaderboard">
                        <div class="leaderboard__content" v-for="(user, index) in leaderboard" :key="user.name">
                            <div v-if="user.id != 1" class="leaderboard__circle">
                                <div class="leaderboard__circle-text" v-html="index+1">
                                </div>
                            </div>
                            <div v-if="user.id != 1" class="leaderboard__card">
                                <div></div>
                                <div class="leaderboard__card-name" v-html="user.name">
                                </div>
                                <div class="leaderboard__card-points" v-html="user.points">
                                </div>
                            </div>
                        </div>
                        <button @click="open = false" class="modal-button"> Закрыть</button>
                    </div>
                </template>
            </vue-modaltor>


            <popover name="foo">
                <div class="popover-text">Нажмите, чтобы открыть рейтинг игроков</div>
            </popover>
            <div class="content__bottom">
                <button class="content__bottom-button" v-on:click="goToLevels()">В ИГРУ!</button>
            </div>
        </div>
    </div>
</template>

<script>
import router from "../router";
export default {
    name: "profileComponent",
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            currentUserName: '',
            usersList: '',
            currentUserPoints: '',
            currentUserIndex: '',
            userInTop: '',
            currentUserLifes: '',
            open: false,
            leaderboard: '',
            showModal: false,
            complexity: '',
        }
    },
    created() {
        this.complexity = this.data.complexity;
    },
    methods: {
        async goToLevels(){
            await this.$router.push({path: '/levels/'}).catch(() => {
            });
            router.go(0);
        },
        async openPopup() {
            await axios.get('/api/getLeaderboard/')
                .then(response => this.leaderboard = response.data.leaderboard)
                .catch();
            this.open = true;
        },
        async logout() {
            await axios.post('/api/logout')
                .then()
                .catch();
            await this.$router.push({path: '/'}).catch(()=>{});
            window.location.reload(true);
        }
    },

}
</script>
