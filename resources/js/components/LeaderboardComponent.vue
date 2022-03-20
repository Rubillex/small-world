<template>
    <div>

    </div>
</template>

<script>
export default {
    name: "LeaderboardComponent",
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            open: false,
        }
    },
}
</script>

<style scoped>

</style>
