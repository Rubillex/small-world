<template>
    <div id="header">
        <h2>Home</h2>
        <br>
        <h3>template-component</h3>
    </div>
</template>

<script>
export default {
    name: "TemplateComponent",
    props: {
        url: String,
    },
    data: () => {
        return {
            pageData: 0,
        }
    },
    mounted() {
        console.log(this.url)
    },
}
</script>


