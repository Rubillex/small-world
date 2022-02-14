<template>
    <div class="template-page">
        <div class="container-header">
            Привет! Как тебя зовут?
            <form ref="nameForm" @submit.prevent="sendForm()">
                <input type="text" v-model="userName" name="name">
                <input type="hidden" name="_token" :value="csrf">
                <button type="submit" class="send js-send">отправить</button>
            </form>
        </div>
    </div>
</template>

<script>
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
        }
    },
    mounted() {
        console.log(this.data)
    },
    methods: {
        async sendForm() {
            if (this.userName !== undefined) {
                let sessionId = null;
                    await axios.post('/api/start-session', {name: this.userName})
                        .then(response => (sessionId = response.data.id))
                        .catch(err => console.log(err));
                await this.$router.push({path: '/game/' + sessionId });
            } else {
                alert('Введите имя!');
            }
            // Проверка обязана быть с тремя равно, потому что иначе приведет к таким результатам
            // Нихуя ты чего придумал, только это нужно было в отдельный метод выносить это отдельная функция
            //sendPostRequest();
            // Тут был забыт await, тебе компилятор об этом сказал, но ты проигнорил
        }
    }
}
</script>
