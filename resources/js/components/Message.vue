<template>

    <li class="clearfix">
        <div v-if="isMe(message.user_id)" class="message-data align-right">
            <span class="message-data-time pr-3">{{ message.created_at | moment("DD-MM-YYYY h:mm:ss")  }}</span>
            <span class="message-data-name">{{ message.name }}</span> <i class="fa fa-circle me"></i>
        </div>
        <div v-else class="message-data">
            <span class="message-data-name">
                <i class="fa fa-circle online"></i>
                {{ message.name }}
            </span>
            <span class="message-data-time">{{ message.created_at | moment("DD-MM-YYYY h:mm:ss")  }}</span>
        </div>

        <div class="message " :class="styleMessage(message.user_id)">
            {{ message.body }}

            <div v-if="message.media && message.media.length > 0">
                <hr>
                <div class="row">
                    <div v-for="(media,index) in message.media"
                         v-bind:key="media.id"
                         :data-index="index">
                        <a data-fancybox="gallery"
                           :href="media.url_real_media"
                           class="d-block mb-1 mr-1">

                            <img v-if="media.is_image"
                                 :src="media.url_real_media"
                                 class="img-fluid img-thumbnail" />

                            <video v-else
                                   :src="media.url_real_media"
                                   :poster="media.url"
                                   class="img-fluid img-thumbnail" ></video>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </li>

</template>

<script>

    export default {
        name: "Message",
        props: {
            message: {}
        },
        methods: {
            isMe(id) {
                return (localStorage.getItem('user_id') || '') == id;
            },
            styleMessage(id) {
                return this.isMe(id) ? 'my-message float-right' : 'other-message float-left';
            }
        }
    }
</script>

<style scoped>
 .img-fluid.img-thumbnail{
     height: 80px;
     width: 80px
 }
</style>
