<template>
    <div>
        Хнык
        <chat :data="data.chatData"></chat>
    </div>
</template>
<script>
import Chat from "./partials/Chat";
export default {
    name: "StartGameComponent",
    components: {Chat},
    props: {
        data: Object,
    },

    data: () => {
        return {
            chatData: '',
        }
    },
}
</script>
