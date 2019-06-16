import login from './Page/Login';
import chat from './Page/Chat';
import Vue from 'vue'
import vueRouter from 'vue-router'
import store from './store';

Vue.use(vueRouter);

const router = new vueRouter({
    mode: 'history',
    // base: process.env.BASE_URL,
    routes: [
        {path: '/login', component: login},
        {path: '/', component: chat},
        {path: '*', redirect: '/login'}
    ]
});

router.beforeEach((to, from, next) => {
    // store.dispatch('fetchAccessToken');
    if (!store.state.accessToken && to.fullPath !== '/login') {
        next('/login');
    }
    next();
});
export default router;
