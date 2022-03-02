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
        /**
         * подключение к вебсокету
         */
        let ws = new WebSocket('ws://194.58.97.130:9000');
        this.myWs = ws;
        let page = this.data.page;
        this.myWs.onopen = function () {
            ws.send(JSON.stringify({ action: 'CONNECT', lobby_id: page }));
        };
        this.myWs.onmessage = function (message) {
            console.log(message.data);
        };
    },
    mounted: function () {

    },
    methods: {
        /**
        * отправка сообщений через вебсокет
        */
        wsSendMessage() {
            if (this.text != null)
            this.myWs.send(JSON.stringify({ action: 'MSG', data: this.text }));
        },

    }
}
</script>

<style scoped>

</style>
