<template>
    <div class="template-page">
        <div class="page-content">
            <div v-if="data.userDifficult === '-1'" class="choose-difficult">
                <h1 class="content-header"><b>Выбери котика-инженера!</b></h1>

                <div class="content-header__text-wrapper">
                    <p class="content-header__text">Выбирая себе компаньона помни, что от него напрямую зависит
                        сложность прохождения игры. Если нет
                        уверенности в выборе, прочти <a href="/home">правила игры</a> ещё раз.</p>
                </div>
                <div class="difficult">
                    <div class="difficult-wrapper">
                        <button v-on:click="changeDifficult(1)" class="difficult__button start">
                            <span class="difficult__button-content">
                                <span class="difficult__button-header">Начинающий</span>
                                <span class="difficult__button-text">Этот котик только начинает свой путь в энергетике, поэтому у него есть целых три попытки!</span>
                                <img class="life" src="images/point_base.png" alt="жызнь"/>
                                <img class="life" src="images/point_base.png" alt="жызнь"/>
                                <img class="life" src="images/point_base.png" alt="жызнь"/>
                                <img class="cat" src="images/evrika_base.png" alt="кит"/>
                            </span>

                        </button>
                        <button v-on:click="changeDifficult(2)" class="difficult__button medium">Продвинутый</button>
                        <button v-on:click="changeDifficult(3)" class="difficult__button hard">Эксперт</button>
                    </div>
                </div>
            </div>
            <div v-else class="go-to-game">
                <h2>Страртовая</h2>
                <button v-on:click="newGame()">Пошли играть!</button>
            </div>
        </div>


        <button v-on:click="logOut()">Выйти</button>
    </div>

</template>

<script>
import router from "../router";

export default {
    name: "TemplateComponent",
    components: {},
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

        async logOut() {
            await axios.post('/api/logout')
                .then()
                .catch(err => console.log(err));
            await this.$router.push({path: '/'});
            window.location.reload(true);
        },

        async changeDifficult(value) {
            await axios.post('/api/change-difficult/' + value)
                .then()
                .catch(err => console.log(err));
            this.data.userDifficult = value;
            alert('Cложность выбрана!');
        }
    }
}
</script>
