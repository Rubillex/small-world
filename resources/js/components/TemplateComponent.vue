<template>
    <div class="template-page">
        <button v-on:click="newGame()">Новая игра</button>
        <br>
        <div class="container-header">
            Подключиться по ID игры
            <form ref="nameForm" @submit.prevent="ConnectToGame()">
                <input type="text" v-model="gameId" name="gameId">
                <input type="hidden" name="_token" :value="csrf">
                <button type="submit" class="send js-send">Подключиться к игре</button>
            </form>
        </div>
        <br>
        <button v-on:click="new LogOut()">Выйти</button>
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
                .then(response => (sessionId = response.data.id))
                .catch(err => console.log(err));
            await this.$router.push({path: '/game/' + sessionId});
            router.go(0);
        },

        async ConnectToGame() {
            if (this.gameId !== undefined) {
                let sessionId = null;
                await axios.post('/api/add-user-to-lobby/' + this.gameId)
                    .then(response => (sessionId = response.data.id))
                    .catch(err => console.log(err));
                await this.$router.push({path: '/game/' + sessionId});
                router.go(0);
            } else {
                alert('Введи ID игры!');
            }
        },

        async LogOut(){
            await axios.post('/api/logout')
                .then()
                .catch(err => console.log(err));
            await this.$router.push({path: '/'});
            router.go(0);
        }
    }
}
</script>
