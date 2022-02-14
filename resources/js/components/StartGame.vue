<template>
    <div>
        AAAAA
    </div>
</template>

<script>
export default {
    name: "StartGame",
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
    beforeCreate(){

    }
}
</script>

<style scoped>

</style>
