import store from './store'

require('./bootstrap');
window.Vue = require('vue');
Vue.use(require('vue-moment'));

import router from './routes'


const app = new Vue({
    el: '#app',
    store,
    router
});
