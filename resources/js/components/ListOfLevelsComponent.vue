<template>
<div>
    Выбор уровня
    <br>
    <div v-for="(item, index) in levelData">
        <div>
            <button v-on:click="goToLevel(index)">{{ item }}</button>
            <br>
        </div>
    </div>
    <button v-on:click="goToProfile()"></button>
</div>
</template>

<script>
import router from "../router";
export default {
    name: "LevelsComponent",
    components: {},
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            levelData: [],
        }
    },
    created() {
        this.getData();
    },
    methods: {
        async getData(){
            await axios.post('/api/getlevels')
                .then(response => {
                    if (!response.data.error) {
                        this.levelData = JSON.parse(response.data.answer);
                        console.log(this.levelData);
                    } else {
                        console.log(response.data.error);
                    }
                })
                .catch(err => console.log(err));
        },

        async goToLevel(levelId){
            await this.$router.push({path: '/level/' + levelId});
            router.go(0);
        },

        async goToProfile() {
            await this.$router.push({path: '/'});
            router.go(0);
        }
    }
}
</script>
