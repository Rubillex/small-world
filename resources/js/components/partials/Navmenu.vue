<template>
    <div class="navbar">
        <div class="navbar__left">
            <a class="navbar__left" @click="goToLevel()">
                {{ FirstLink }}
            </a>
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
        FirstLink: {
            type: String,
            default: 'На главную'
        },
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
            navBarLinkFirst: 'На главную',
            navBarLinkSecond: 'Мой прогресс',
            navBarLinkExit: 'Выход'
        }

    },

    methods: {
        async goToLevel(){
            await this.$router.push({path: '/levels/'}).catch(() => {
            });
            router.go(0);
        },

        async profile() {
            await this.$router.push({path: '/profile/'}).catch(() => {
            });
            router.go(0);
        },

        async logout() {
            await axios.post('/api/logout')
                .then()
                .catch(err => console.log(err));
            await this.$router.push({path: '/'}).catch(() => {
            });
            router.go(0);
        }
    },
}
</script>
