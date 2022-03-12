<template>
    <div class="template-page">
        <div v-if="data.userDifficult === '-1'" class="choose-difficult">
            <h1>Привет! Выбери уровень сложности:</h1>
                <ul>
                    <li><button v-on:click="changeDifficult(0)">Я новичек</button></li>
                    <li><button v-on:click="changeDifficult(1)">Я смешарик</button></li>
                    <li><button v-on:click="changeDifficult(2)">Бывалый.</button></li>
                </ul>
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
            let sessionId = null;
            await axios.post('/api/start-session')
                .then(response => {
                    if (!response.data.error) {
                        sessionId = response.data.id
                    } else {
                        console.log('response');
                    }
                })
                .catch(err => console.log(err));
            if (sessionId) {
                await this.$router.push({path: '/game/' + sessionId});
                router.go(0);
            }
        },

        async connectToGame() {
            if (this.gameId === undefined) {
                alert('Введи ID игры!');
                return null;
            }
                let sessionId = null;
                let erorr = null;
                await axios.post('/api/add-user-to-lobby/' + this.gameId)
                    .then(response => {
                        erorr = response.data.error;
                        if (erorr) {
                            alert(erorr);
                            return null;
                        }

                        sessionId = response.data.id
                    })
                    .catch(err => console.log(err));
                if (sessionId) {
                    await this.$router.push({path: '/game/' + sessionId});
                    router.go(0);
                }
        },

        async logOut() {
            await axios.post('/api/logout')
                .then()
                .catch(err => console.log(err));
            await this.$router.push({path: '/'});
            router.go(0);
        },

        async changeDifficult(value) {
            console.log(222222222);
            await axios.post('/api/change-difficult/' + value)
                .then()
                .catch(err => console.log(err));
        }
    }
}
</script>
