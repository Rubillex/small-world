<template>
    <div>
        <div class="container-header">
            Привет! Как тебя зовут?
            <form ref="nameForm" @submit.prevent="sendForm()">
                <input type="text" v-model="userName" name="name">
                <input type="hidden" name="_token" :value="csrf">
                <button type="submit" class="send js-send"></button>
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
            console.log(this.csrf);
            if (!this.$refs.nameForm.name.value) {
                alert('Введите имя!');
                return;
            }
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;
            try {
                const response = await axios.post('/api/start-session', {name: this.userName});
            } catch (e) {
                console.log(e);
            }
        },
    }
}

</script>


<style lang="scss">
.container-header {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;

    div {
        padding: 20px 40px;
    }
}

.container-header + hr {
    width: 100%;
    align: center;
}

.site-footer {
    background-color: #26272b;
    padding: 45px 0 10px;
    font-size: 15px;
    line-height: 24px;
    color: #737373;
}
</style>

