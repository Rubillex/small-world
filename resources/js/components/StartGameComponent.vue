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
        }
    },
    beforeCreate(){
    },
    created: function() {
        console.log("Starting connection to WebSocket Server");
        this.myWs = new WebSocket('ws://localhost:9000');

        this.myWs.onopen = function () {

        };
        this.myWs.onmessage = function (message) {

        };
    },

    methods: {
        wsSendMessage() {
            this.myWs.send(JSON.stringify({ action: 'MSG', data: this.text }));
        },

        wsSendPing() {
            this.myWs.send(JSON.stringify({ action: 'PING' }));
        }
    }
}
</script>

<style scoped>

</style>
