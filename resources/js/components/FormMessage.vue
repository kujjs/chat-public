<template>
    <div>

        <div class="chat-message clearfix">
            <label for="body"></label>
            <textarea :disabled="sending"
                      name="body"
                      id="body"
                      class="form-control"
                      placeholder="Type your message"
                      rows="3"
                      v-model="message"></textarea>
            <button class="btn btn-link"
                    data-toggle="tooltip" data-placement="right" title="Attach Media"
                    :disabled="sending"
                    @click.prevent="showModal">
                <i class="fas fa-photo-video"></i>
            </button>

            <img v-for="file in files" :src="file.url" width="80" height="80" alt="">

            <button :disabled="sending"
                    class="btn btn-outline-dark float-right"
                    data-toggle="tooltip" data-placement="right" title="Send Message"
                    @click.prevent="sendMessage">
                <i class="far fa-paper-plane"></i>
            </button>


            <div ref="modal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <upload-component ref="uploadComponent"></upload-component>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light " data-dismiss="modal" @click="clearUpload()">Clean</button>
                            <button class="btn btn-outline-dark " data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <error-component></error-component>
        </div> <!-- end chat -->
    </div>
</template>

<script>
    import uploadComponent from '../components/Upload';
    import errorComponent from '../components/Errors';

    export default {
        name: "FormMessage",
        mounted(){
            $('[data-toggle="tooltip"]').tooltip()
        },
        data() {
            return {
                message: '',
            }
        },
        components: {
            uploadComponent,
            errorComponent
        },

        computed: {
            sending() {
                return this.$store.state.sending;
            },
            files() {
                return this.$store.state.files;
            }
        },
        methods: {
            sendMessage() {
                if (this.message.trim() === '') {
                    this.message = '';
                    this.$store.dispatch('pushError','The message field is required.')
                    return
                }

                this.$store.dispatch('clearError');

                this.$store.dispatch('sendMessage', {message: this.message}).then(() => {
                    this.message = '';
                    this.$store.dispatch('clearFiles');
                    this.$refs.uploadComponent.clearUpload();
                });

            },
            showModal() {
                $(this.$refs.modal).modal('show');
            },
            clearUpload(){
                this.$store.dispatch('clearError');
                this.$refs.uploadComponent.clearUpload();
            }
        }


    }
</script>

<style scoped>

</style>
