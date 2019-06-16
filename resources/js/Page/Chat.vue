<template>
    <div class="row pt-5">
        <div class=" col-6 pr-5">
            <form-messages></form-messages>
        </div>
        <div class=" col-6" id="messages">
            <list-messages></list-messages>
        </div>
    </div>
</template>

<script>
    import formMessages from '../components/FormMessage';
    import listMessages from '../components/ListMessage';

    export default {
        name: "Chat",
        created() {
            this.$store.dispatch('getMessages');
            Echo.join('chat')
                .here(users => {
                    console.log(users)
                })
                .joining(user => {
                    console.log(user);
                })
                .listen('newMessageEvent', (e) => {
                    this.$store.dispatch('setMessage', e.message);
                });
        },
        components: {
            listMessages,
            formMessages
        }
    }
</script>

<style scoped>

</style>
