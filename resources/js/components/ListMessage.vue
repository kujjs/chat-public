<template>
    <div>
        <div v-if="loading">
            <h2>Cargado...</h2>
        </div>
        <div v-else-if="messages.length === 0" class="alert alert-info">
            <h4>No messages yet</h4>
        </div>
        <div v-else>
            <message-component v-for="message in messages"
                               v-bind:key="message.id"
                               :message="message"></message-component>
        </div>
    </div>
</template>

<script>
    import messageComponent from './message';
    import '@fancyapps/fancybox/dist/jquery.fancybox.css'
    export default {
        name: "ListMessage",
        computed: {
            messages() {
                return this.$store.state.messages;
            },
            loading(){
                return this.$store.state.loading;
            }
        },
        components:{
            messageComponent
        }
    }
</script>

<style scoped>

</style>
