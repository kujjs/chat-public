<template>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="errors.length > 0">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h3>Please resolve the following errors:</h3>
        <ul>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "Errors",
        computed: {
            errors() {
                return this.$store.state.errors;
            }
        },
        methods:{
            close(){
                this.$store.dispatch('clearError');
            }
        }
    }
</script>

<style scoped>

</style>
