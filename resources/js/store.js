import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        messages: [],
        files: [],
        errors: [],
        loading: false,
        sending: false
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
        clearFiles({commit}) {
            commit('clean_files')
        },
        getMessages({commit}) {
            commit('change_loading', true);
            axios.get('/messages').then(res => {
                commit('set_messages', res.data);
                commit('change_loading', false);
            })

        },
        setSending({commit}, state) {
            commit('change_sending', state);
        },
        sendMessage({commit, state, getters}, data) {
            commit('change_sending', true);

            let sendData = {
                id: getters.messagesId[0] + 1,
                name: data.user,
                body: data.message,
                media: state.files,
                created_at: Date.now(),
                updated_at: Date.now(),
            };

            commit('set_message', sendData);

            axios.post('/', sendData).then(res => {

            });
            commit('change_sending', false);

        }
    }
});


