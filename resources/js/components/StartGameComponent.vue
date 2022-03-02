<template>
    <div>
        <div class="container-header">
            <form ref="nameForm" @submit.prevent="wsSendMessage()">
                <input type="text" v-model="text" name="text">
                <input type="hidden" name="_token" :value="csrf">
                <button type="submit" class="send js-send">Отправить</button>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    name: "StartGameComponent",
    components: {},
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            pageData: 0,
            text: '',
            myWs: null,
            page: ''
        }
    },
    beforeCreate(){

    },
    created: function() {
        console.log("Starting connection to WebSocket Server");
        let ws = new WebSocket('ws://localhost:9000');
        this.myWs = ws;
        let page = this.data.page;
        this.myWs.onopen = function () {
            console.log('id send');
            ws.send(JSON.stringify({ action: 'CONNECT', lobby_id: page }));
        };
        this.myWs.onmessage = function (message) {
            console.log(message.data);
        };
    },
    mounted: function () {

    },
    methods: {
        wsSendMessage() {
            console.log('msg');
            this.myWs.send(JSON.stringify({ action: 'MSG', data: this.text }));
        },

        wsSendPing() {
            this.myWs.send(JSON.stringify({ action: 'PING' }));
        },

        wsSendLobbyId(){
            console.log('id send');
            console.log(this.data.page);
            this.myWs.send(JSON.stringify({ action: 'CONNECT', lobby_id: this.data.page }));
        }
    }
}
</script>

<style scoped>

</style>
