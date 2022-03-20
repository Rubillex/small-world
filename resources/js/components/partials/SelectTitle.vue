<template>
    <div class="test-select">
        <h2 class="test-select__title">{{ title }}</h2>
        <img class="test-select__img" src="/images/main_cat.svg" alt="а котека то нет">
    </div>
</template>

<script>
export default {
    name: 'SelectTitle',

    data() {
        return {
            title: "Выбор уровня"
        }
    }
}
</script>
