<template>
    <div>

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
        }
    },
    beforeCreate(){

    },
    methods: {

    }
}
</script>

<style scoped>

</style>
