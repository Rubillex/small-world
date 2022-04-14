<template>
    <div class="navbar">
        <div class="navbar__left">
            <a class="navbar__left" @click="profile()">
                {{ SecondLink }}
            </a>
        </div>
        <a class="navbar__right" @click="logout()">
            {{ ExitLink }}
        </a>
    </div>
</template>

<script>
import router from "../../router";

export default {
    name: 'navMenu',

    props: {
        SecondLink: {
            type: String,
            default: 'Мой прогресс'
        },
        ExitLink: {
            type: String,
            default: 'Выход'
        },
    },

    data() {
        return {
            navBarLinkSecond: 'Мой прогресс',
            navBarLinkExit: 'Выход'
        }

    },

    methods: {

        async profile() {
            await this.$router.push({path: '/profile/'}).catch(() => {
            });
            router.go(0);
        },

        async logout() {
            await axios.post('/api/logout')
                .then()
                .catch();
            await this.$router.push({path: '/'}).catch(() => {
            });
            router.go(0);
        }
    },
}
</script>
