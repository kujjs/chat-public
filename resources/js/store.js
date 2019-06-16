import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import router from './routes';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        name: localStorage.getItem('name') || '',
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

            state.messages.unshift(message);
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
        }


    },
    actions: {
        pushFile({commit}, file) {
            commit('set_file', file)

        },
        removeFile({commit}, file) {
            //TODO:axio remove file in server
            commit('remove_file', file)
        },
        pushError({commit}, error) {
            commit('set_error', error);
        },
        clearError({commit}) {
            commit('clean_error');
        },
        setMessage({commit},message) {
            commit('set_message',message);
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
            commit('change_sending', true);
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + state.accessToken;
            let sendData = {
                id: getters.messagesId[0] + 1,
                name: state.name,
                body: data.message,
                media: state.files,
                created_at: Date.now(),
                updated_at: Date.now(),
            };

            commit('set_message', sendData);

            axios.post('/api/messages', sendData).then(res => {

            });
            commit('change_sending', false);

        },
        login({commit, state}, data) {
            commit('change_sending', true);
            axios.post('/api/login', data).then(res => {

                localStorage.setItem('accessToken', res.data.access_token);
                localStorage.setItem('name', res.data.name);
                commit('setAccessToken', res.data.access_token);
                commit('set_name', res.data.name);
                router.push('/');
                commit('change_sending', false);
            }, error => {
                console.log(error.message)
                commit('change_sending', false);
            });

        },
        logout({commit, state}, data) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + state.accessToken;
            commit('change_sending', true);

            axios.post('/api/logout', data).then(res => {
                localStorage.setItem('accessToken', null);
                commit('setAccessToken', null);
                router.push('/login');
                commit('change_sending', false);
            }, error => {
                localStorage.setItem('accessToken', null);
                commit('setAccessToken', null);
                commit('change_sending', false);
            });
        }
    }
});


