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
        },
        async submitFile() {
            let formData = new FormData;
            formData.set('image', this.file);
            await axios.post('/api/upload-image', formData)
                .then(response => alert('http://185.46.8.127/storage/' + response.data.path))
                .catch(err => console.log(err));
        },
    }
}
</script>

<style scoped>

</style>
