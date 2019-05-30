<template>

    <div class="border-bottom">
        <p>{{ message.name }} <span
                class="text-secondary"> — {{ message.created_at | moment("DD-MM-YYYY h:mm:ss")  }}</span></p>
        <p class="text-justify">
            {{ message.body }}

        </p>

        <div class="row text-center text-lg-left">

            <div v-for="(media,index) in message.media"
                 v-bind:key="media.id"
                 :data-index="index"
                 class="col-lg-3 col-md-4 col-xs-6">
                <a data-fancybox="gallery"
                   :href="media.url_real_media"
                   class="d-block mb-4 h-100">

                    <img v-if="media.is_image"
                         :src="media.url_real_media"
                         class="img-fluid img-thumbnail"/>

                    <video v-else
                           :src="media.url_real_media"
                           :poster="media.url"
                           class="img-fluid img-thumbnail"></video>

                </a>
            </div>
        </div>

    </div>


</template>

<script>

    export default {
        name: "message",
        props: {
            message: {}
        }
    }
</script>

<style scoped>

</style>
