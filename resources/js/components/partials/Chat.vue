<template>
<div class="chat">
        <form ref="nameForm" @submit.prevent="wsSendMessage()">
            <input type="text" v-model="text" name="text">
            <button type="submit" class="send js-send">Отправить</button>
        </form>
        <div class="chat-box">
            <h3>Ламповый чатек: </h3>
            <p class="message" v-for="message in messages">
                <span :class="message.sender === data.userData.name ? 'name__my' : 'name'" v-html="message.sender" />: <span class="data" v-html="message.data" />
            </p>
        </div>
</div>
</template>

<script>
export default {
    name: "Chat",
    props: {
        data: Object,
    },

    data: () => {
        return {
            text: '',
            myWs: null,
            messages: [],
            userData: {}
        }
    },

    /**
     * подключение к вебсокету
     */
    created() {
        console.log(this.data);
        let data = this.data;
        this.myWs = new WebSocket('ws://194.58.97.130:9000');
        this.myWs.onopen = function (something = ':)', userName = data.userData.name, lobbyId = data.lobbyId) {
            this.send(JSON.stringify(
                {   action: 'connectToLobby',
                    data: {
                        lobbyId:  lobbyId,
                        userName: userName,
                    }
                }));
        };
        this.myWs.onmessage = (message) => {
            message =  JSON.parse(message.data);
            this.messages.push({data: message.msg, sender: message.sender});
            console.log(this.messages);
        };
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
