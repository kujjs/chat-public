<template>
    <div>
        <error-component></error-component>
        <div class="form-group">
            <label for="name">Username</label>
            <input :disabled="sending"
                   type="text"
                   name="name"
                   id="name"
                   class="form-control"
                   v-model="user"/>
        </div>
        <div class="form-group">
            <label for="body">Message</label>

            <textarea :disabled="sending"
                      name="body"
                      id="body"
                      class="form-control"
                      rows="6"
                      v-model="message"></textarea>
        </div>
        <upload-component ref="uploadComponent" :url="urlUpload"></upload-component>
        <div class="form-group">
            <button :disabled="sending" class="btn btn-block btn-primary" @click="sendMessage">Send</button>
        </div>
    </div>
</template>

<script>
    import uploadComponent from '../components/Upload';
    import errorComponent from '../components/Errors';

    export default {
        name: "FormMessage",
        data() {
            return {
                user: '',
                message: ''
            }
        },
        components: {
            uploadComponent,
            errorComponent
        },


        props: {
            urlUpload: {
                type: String,
                required: true
            }
        },

        computed: {
            sending() {
                return this.$store.state.sending;
            }
        },
        methods: {
            sendMessage() {

                this.$store.dispatch('sendMessage', {user: this.user, message: this.message});

                this.user = '';
                this.message = '';
                this.$store.dispatch('clearFiles');
                this.$refs.uploadComponent.clearUpload();

            }
        }


    }
</script>

<style scoped>

</style>
