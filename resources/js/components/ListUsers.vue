<template>
    <div>
        <div class="users pt-1">
            <h3>Online Users</h3>
            <ul class="list-user">

                <li> {{ user_name }} - <a href="" @click.prevent="logout">logout</a></li>
                <li v-for="user in users">
                    <span v-if="!isMe(user.id)"> {{ user.name }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ListUsers",
        computed: {
            users() {
                return this.$store.state.users;
            },
            user_name() {
                return this.$store.state.name;
            },
            user_id() {
                return localStorage.getItem('user_id') || '';
            }
        },
        methods: {
            isMe(id) {
                return this.user_id == id;
            },
            logout() {
                this.$store.dispatch('logout');
            }
        }
    }
</script>

<style scoped lang="scss">
    .users {
        width: 100%;
        float: right;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;

        .list-user {
            padding-top: 20px;
            padding-bottom: 20px;
            padding-right: 30px;
            border-bottom: 2px solid white;
            overflow-y: scroll;
            height: 90vh;
        }

    }
</style>
