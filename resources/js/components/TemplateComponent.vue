<template>
    <div class="template-page">
        <div v-if="data.userDifficult === '-1'" class="choose-difficult">
            <h1>Привет! Выбери уровень сложности:</h1>
                <ul>
                    <li><button v-on:click="changeDifficult(0)">Начинающий</button></li>
                    <li><button v-on:click="changeDifficult(1)">Продвинутый</button></li>
                    <li><button v-on:click="changeDifficult(2)">Эксперт</button></li>
                </ul>
        </div>
        <div v-else class="go-to-game">
            <h2>Страртовая</h2>
            <button v-on:click="newGame">Пошли играть!</button>
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
