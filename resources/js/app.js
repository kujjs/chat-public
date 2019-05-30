import store from './store'


require('./bootstrap');

window.Vue = require('vue');
Vue.use(require('vue-moment'));



Vue.component('form-message', require('./components/FormMessage').default);
Vue.component('list-message', require('./components/ListMessage').default);

const app = new Vue({
    el: '#app',
    store,
    created() {
        this.$store.dispatch('getMessages');
        // this.fetchMessages();
        // window.Echo.join('test').listen('Hola',asd=>{
        // window.Echo.channel('test').listen('Hola',asd=>{
        // window.Echo.channel('test')
        //     .listen('testEvent',()=>{
        //         alert('hola');
        //     console.log('lorem');
        //  });
    }
});
