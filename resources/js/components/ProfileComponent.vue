<template>
    <div class="page-content">
        <div class="content">
            <div class="content__top">
                <div class="content__top-button">
                    На главную
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
                        <img class="content__card__column__left__img" src="/images/leader_cat.svg" alt="а котека то нет">
                        <div class="content__card__column__left__userLifes">
                            <img class="content__card__column__left__userLifes__img"
                                 src="/images/point_base.png" alt="а хп нет :("
                                 v-for="life in this.data.currentUserLifes">
                        </div>
                    </div>
                    <div class="content__card__column__right">
                        <p class="content__card__column__right__points-title">
                            Мой счет
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
            <vue-modaltor :visible="open">
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
                        <div class="content__card__column__right__leader-board-content" v-for="(user, index) in leaderboard" :key="user.name">
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
            leaderboard: ''
        }
    },
    created() {
        console.log(this.data);
    },
    methods: {
        async goToLevels() {
            await this.$router.push({path: '/levels/'}).catch(()=>{});
            router.go(0);
        },
        async openPopup() {
            await axios.get('/api/getLeaderboard/')
                .then(response => this.leaderboard = response.data.leaderboard)
                .catch(err => console.log(err));
            console.log(this.leaderboard);
            this.open = true;
        },
        async logout() {
            await axios.post('/api/logout')
                .then()
                .catch(err => console.log(err));
            await this.$router.push({path: '/'}).catch(()=>{});
            window.location.reload(true);
        }
    },

}
</script>
