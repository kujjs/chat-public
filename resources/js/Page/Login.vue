<template>
    <div class="row">
        <div class="col-sm-6 offset-3 p-5">
            <div class="card">
                <article class="card-body">
                    <h4 class="card-title mb-4 mt-1">Connect to Chat
                        <span class="badge badge-info badge-pill text-white float-sm-right">0 online</span>
                    </h4>

                    <form method="post" v-on:submit.prevent="login">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   placeholder="Name"
                                   v-model="name"
                                   class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email"
                                   class="form-control"
                                   placeholder="Email"
                                   type="email"
                                   v-model="email"
                            />
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div> <!-- form-group// -->

                    </form>
                </article>
            </div> <!-- card.// -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data(){
          return {
              name:'Demo',
              email:'demo@example.com'
          };
        },
        methods:{
            login(){
                this.$store.dispatch('login', {
                    name:this.name,
                    email:this.email
                });
            }
        }
    }
</script>

<style scoped>

</style>
