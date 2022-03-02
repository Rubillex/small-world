<template>
    <div class="template-page">
        <button v-on:click="newGame()">Новая игра</button>
        <br>
        <div class="container-header">
            Подключиться по ID игры
            <form ref="nameForm" @submit.prevent="connectToGame()">
                <input type="text" v-model="gameId" name="gameId">
                <input type="hidden" name="_token" :value="csrf">
                <button type="submit" class="send js-send">Подключиться к игре</button>
            </form>
        </div>
        <br>
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
            gameId: ''
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

        async logOut(){
            await axios.post('/api/logout')
                .then()
                .catch(err => console.log(err));
            await this.$router.push({path: '/'});
            router.go(0);
        }
    }
}
</script>
