<template>
    <div class="navbar">
        <div class="navbar__left">
            <a class="navbar__left">
                {{ FirstLink }}
            </a>
            <a class="navbar__left">
                {{ SecondLink }}
            </a>
        </div>
        <a class="navbar__right">
            {{ ExitLink }}
        </a>
    </div>
</template>

<script>
export default {
    name: 'navMenu',

    props: {
        FirstLink: {
            type: String,
            default: 'На главную'
        },
        SecondLink: {
            type: String,
            default: 'Мой Прогрес'
        },
        ExitLink: {
            type: String,
            default: 'Выход'
        }
    },
}
</script>
