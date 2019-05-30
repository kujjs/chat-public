<template>
    <div  class="form-group">

        <vue-dropzone id="dropzoneFile"
                      :options="dropOptions"
                      :useCustomSlot=true
                      @vdropzone-error="errorUpload"
                      @vdropzone-success="successUpload"
                      @vdropzone-removed-file="deleteUpload"
                      class="dropzone"
                      ref="dropzoneFile"

        >
            <div class="dropzone-custom-content">
                <h3 class="dropzone-custom-title">Drag and drop to upload content!</h3>
                <div class="subtitle">...or click to select a file from your computer</div>
            </div>
        </vue-dropzone>
    </div>
</template>

<script>
    import vueDropzone from "vue2-dropzone";
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        name: "uploadComponent",
        props: {
            url: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                dropOptions: {
                    url: this.url,
                    params: {_token: window.axios.defaults.headers.common['X-CSRF-TOKEN']},
                    acceptedFiles: "image/*,video/*",
                    paramName: "file", // The name that will be used to transfer the file
                    addRemoveLinks: true,
                    uploadMultiple: true,
                    maxFilesize: 20, // MB
                    parallelUploads: 1,
                    dictRemoveFile: 'Remove',
                    dictInvalidFileType: 'Remove',

                }
            }
        },
        components: {
            vueDropzone
        },
        methods: {
            successUpload(file, response) {
                this.$store.dispatch('pushFile', response);
            },
            deleteUpload(file, error, xhr) {
                this.$store.dispatch('removeFile', JSON.parse(file.xhr.responseText));
            },
            errorUpload(file, message, xhr) {

                if (xhr !== undefined && xhr.status === 422) {
                    $.each(message.errors, (key, value) => {
                        this.$store.dispatch('pushError', value[0]);
                        $(file.previewElement).find(".dz-error-message span").text(value[0]);
                    });

                }
            },
            clearUpload(){
                this.$refs.dropzoneFile.removeAllFiles();
            }
        }
    }
</script>

<style scoped>

</style>
