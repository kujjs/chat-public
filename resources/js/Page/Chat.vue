<template>
    <div class="clearfix">
        <div class="row">
            <div class="col-md-8">
                <div class="chat">
                    <div id="chat-history" class="chat-history col-12">
                        <ul>
                            <list-messages></list-messages>
                        </ul>
                    </div> <!-- end chat-history -->

                    <div class="col-12">
                        <form-messages></form-messages>
                    </div>
                </div> <!-- end container -->
            </div>
            <div class="col-md-4">
                <list-users></list-users>
            </div>
        </div>
    </div> <!-- end chat-message -->

</template>

<script>
    import formMessages from '../components/FormMessage';
    import listMessages from '../components/ListMessage';
    import listUsers from '../components/ListUsers';
    export default {
        name: "Chat",
        created() {
            this.$store.dispatch('getMessages');
            Echo.join('chat')
                .here(users => {
                    console.log(users)
                    this.$store.dispatch('setUsers', users);
                })
                .joining(user => {
                    console.log(user,this.$store.user_id)
                    if (user.id != this.$store.user_id){
                        this.$store.dispatch('pushUser', user);

                    }
                })
                .leaving(user => {
                    console.log('leaving',user)
                    this.$store.dispatch('removeUser', user);
                })
                .listen('newMessageEvent', (e) => {
                    this.$store.dispatch('setMessage', e.message);
                });

        },
        components: {
            listMessages,
            formMessages,
            listUsers
        }
    }
</script>

<style lang="scss">
    $green: #7cb2bb;
    $blue: #7f89ed;
    $gray: #92959E;

    *, *:before, *:after {
        box-sizing: border-box;
    }

    li {
        list-style-type: none;
    }

    .chat {
        width: 100%;
        float: left;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;

        .chat-history {
            padding-top: 20px;
            padding-bottom: 20px;
            padding-right: 30px;
            border-bottom: 2px solid white;
            overflow-y: scroll;
            height: 75vh;

            .message-data {
                margin-bottom: 15px;
            }

            .message-data-time {
                color: lighten($gray, 8%);
                padding-left: 6px;
            }

            .message {
                color: white;
                padding: 18px 20px;
                line-height: 26px;
                font-size: 16px;
                border-radius: 7px;
                margin-bottom: 30px;
                position: relative;
                min-width: 30%;
                max-width: 70%;

                &:after {
                    bottom: 100%;
                    left: 90%;
                    border: solid transparent;
                    content: " ";
                    /*height: 0;*/
                    /*width: 0;*/
                    position: absolute;
                    pointer-events: none;
                    border-bottom-color: $green;
                    border-width: 10px;
                    margin-left: -10px;
                }
            }

            .my-message {
                background: $green;
            }

            .other-message {
                background: $blue;

                &:after {
                    border-bottom-color: $blue;
                    left: 7%;
                }
            }

        }

        .chat-message {
            padding: 20px;

            textarea {
                width: 100%;
                border: 1px solid #ccc;
                padding: 10px 20px;
                font: 14px/22px "Lato", Arial, sans-serif;
                margin-bottom: 10px;
                border-radius: 5px;

                resize: none;
                background-color: #eee;

            }


        }
    }


    .online {

        color: $blue;
    }

    .me {
        color: $green;
    }

    .align-left {
        text-align: left;
    }

    .align-right {
        text-align: right;
    }


    .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
    }


</style>
