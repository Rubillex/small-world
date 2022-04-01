<template>
<div>
    <form @submit.prevent="submitFile">
        <input type="file" @change="handleFileUpload()"/>
        <button>Подтвердить</button>
    </form>
</div>
</template>

<script>
export default {
    name: "UploadImageComponent",
    props: {
        data: Object,
    },
    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            path: '',
            file: '',
        }
    },
    methods: {
        handleFileUpload() {
            this.file = event.target.files[0];
            console.log(this.file);
        },
        async submitFile() {
            let formData = new FormData;
            console.log(this.file);
            formData.set('image', this.file);
            console.log(this.data.levelId);
            await axios.post('/api/upload-image', formData)
                .then(response => alert('http://194.58.97.130/storage/' + response.data.path))
                .catch(err => console.log(err));
        },
    }
}
</script>

<style scoped>

</style>
