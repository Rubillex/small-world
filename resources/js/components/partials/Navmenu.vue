<template>
    <div class="navbar">
        <div class="navbar__left">
            <a class="navbar__left">
                {{ navBarLinkFirst }}
            </a>
            <a class="navbar__left">
                {{ navBarLinkSecond }}
            </a>
        </div>
        <a class="navbar__right">
            {{ navBarLinkExit }}
        </a>
    </div>
</template>

<script>
export default {
    name: 'navMenu',

    data() {
        return {
            navBarLinkFirst: 'На главную',
            navBarLinkSecond: 'Мой Прогрес',
            navBarLinkExit: 'Выход'
        }
    }
}
</script>
