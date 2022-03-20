<template>
    <div class="navbar">
        <div class="navbar__left">
            <a class="navbar__left">
                {{ navBarLinkFirst }}
            </a>
            <a class="navbar__left" @click="profile()">
                {{ navBarLinkSecond }}
            </a>
        </div>
        <a class="navbar__right" @click="logout()">
            {{ navBarLinkExit }}
        </a>
    </div>
</template>

<script>
import router from "../../router";

export default {
    name: 'navMenu',

    data() {
        return {
            navBarLinkFirst: 'На главную',
            navBarLinkSecond: 'Мой прогресс',
            navBarLinkExit: 'Выход'
        }
    },

    methods: {
        async profile() {
            await this.$router.push({path: '/profile/'});
            router.go(0);
        },
        async logout() {
            await axios.post('/api/logout')
                .then()
                .catch(err => console.log(err));
            await this.$router.push({path: '/'});
            window.location.reload(true);
        }
    }
}
</script>
