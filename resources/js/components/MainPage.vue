<template>
<div>
</div>
</template>

<script>
export default {
    name: "MainPage",
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

    }
}
</script>

<style scoped>

</style>
