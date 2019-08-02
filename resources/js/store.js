import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import router from './routes';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user_id: localStorage.getItem('user_id') || '',
        name: localStorage.getItem('name') || '',
        users: [],
        messages: [],
        files: [],
        errors: [],
        loading: false,
        sending: false,
        accessToken: localStorage.getItem('accessToken') || null
    },
    getters: {
        filesId: state => {
            return state.files.map(file => file.id)
        },
        messagesId: state => {
            return state.messages.map(message => message.id)
        }

    },
    mutations: {
        set_messages(state, messages) {
            state.messages = messages;
        },
        set_message(state, message) {
            state.messages.push(message);
        },
        remove_message(state, message) {
            let i = state.messages.map(item => item.id).indexOf(message.id);
            state.messages.splice(i, 1);
        },
        set_file(state, file) {
            state.files.push(file);
        },
        remove_file(state, file) {
            let i = state.files.map(item => item.id).indexOf(file.id);
            state.files.splice(i, 1);
        },
        set_error(state, error) {
            state.errors.push(error);
        },
        clean_error(state) {
            state.errors = [];
        },
        clean_files(state) {
            state.files = [];
        },
        change_loading(state, loading) {
            state.loading = loading
        },
        change_sending(state, sending) {
            state.sending = sending
        },
        setAccessToken(state, token) {
            state.accessToken = token
        },
        set_name(state, name) {
            state.name = name
        },
        set_userId(state, id) {
            state.id = id
        },
        set_users(state, users) {
            state.users = users;
        },
        push_user(state, user) {
            state.users.push(user);
        },
        remove_user(state, user) {
            let i = state.users.map(item => item.id).indexOf(user.id);
            state.users.splice(i, 1);
        },
    },
    actions: {
        pushFile({commit}, file) {
            commit('set_file', file)

        },
        removeFile({commit}, file) {
            //TODO: add axio remove file in server
            commit('remove_file', file)
        },
        pushError({commit}, error) {
            commit('set_error', error);
        },
        clearError({commit}) {
            commit('clean_error');
        },
        setMessage({commit}, message) {
            commit('set_message', message);
        },
        clearFiles({commit}) {
            commit('clean_files')
        },
        getMessages({commit, state}) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + state.accessToken;
            commit('change_loading', true);
            axios.get('/api/messages').then(res => {
                commit('set_messages', res.data);
                commit('change_loading', false);

            })

        },
        setSending({commit}, state) {
            commit('change_sending', state);
        },
        sendMessage({commit, state, getters}, data) {
            return new Promise((resolve,reject) => {
                commit('change_sending', true);
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + state.accessToken;
                let sendData = {
                    id: getters.messagesId[getters.messagesId.length],
                    user_id: state.user_id,
                    name: state.name,
                    body: data.message,
                    media: state.files,
                    created_at: Date.now(),
                    updated_at: Date.now(),
                };

                commit('set_message', sendData);

                axios.post('/api/messages', sendData).then(res => {
                    resolve(res);
                    commit('clean_error');
                    commit('change_sending', false);
                }).catch(error => {
                    reject(error.response.data.errors);
                    commit('clean_error');
                    commit('change_sending', false);
                    commit('set_error', error.response.data.errors.body[0]);
                    commit('remove_message', sendData);
                });
            });
        },
        login({commit, state}, data) {
            commit('change_sending', true);
            axios.post('/api/login', data).then(res => {

                localStorage.setItem('user_id', res.data.id);
                localStorage.setItem('accessToken', res.data.access_token);
                localStorage.setItem('name', res.data.name);

                commit('set_userId', res.data.id);
                commit('setAccessToken', res.data.access_token);
                commit('set_name', res.data.name);

                commit('change_sending', false);
                router.push('/');
            }, error => {
                console.log(error.message);
                commit('change_sending', false);
            });

        },
        logout({commit, state}) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + state.accessToken;
            commit('change_sending', true);

            axios.post('/api/logout').then(res => {}, error => {});
            commit('change_sending', false);
            window.Echo.leave('chat');
            localStorage.setItem('user_id', null);
            localStorage.setItem('accessToken', null);
            localStorage.setItem('name', null);

            commit('set_userId', null);
            commit('setAccessToken', null);
            commit('set_name', null);
            router.push('/login');

        },
        setUsers({commit}, data) {
            commit('set_users', data);
        },
        pushUser({commit}, data) {
            commit('push_user', data);
        },
        removeUser({commit}, data) {
            commit('remove_user', data);
        },


    }
});


