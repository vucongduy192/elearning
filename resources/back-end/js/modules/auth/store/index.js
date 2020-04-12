import Cookies from 'js-cookie';
import axios from 'axios';

const SAVE_TOKEN = 'auth/save_token';
const FETCH_USER_SUCCESS = 'auth/fetch_user_success';
const FETCH_USER_FAILURE = 'auth/fetch_user_failure';
const LOGOUT = 'auth/logout';

const state = {
    auth_user: null,
    token: Cookies.get('token'),
};

const mutations = {
    [SAVE_TOKEN](state, { token, remember }) {
        state.token = token;
        Cookies.set('token', token, { expires: 70000 });
    },

    [FETCH_USER_SUCCESS](state, { auth_user }) {
        state.auth_user = auth_user;
    },

    [FETCH_USER_FAILURE](state) {
        state.token = null;
        Cookies.remove('token');
    },

    [LOGOUT](state) {
        state.auth_user = null;
        state.token = null;

        Cookies.remove('token');
    },
};

const actions = {
    saveToken({ commit }, { token, remember }) {
        axios.defaults.headers.common[
            'Authorization'
        ] = `${token.token_type} ${token.access_token}`;

        commit(SAVE_TOKEN, { token, remember });
    },
    async fetchUser({ commit }) {
        try {
            const { data } = await axios.get('/user');

            commit(FETCH_USER_SUCCESS, { auth_user: data });
        } catch (error) {
            commit(FETCH_USER_FAILURE);
        }
    },
    async logout({ commit }) {
        try {
            await axios.post('/logout');
        } catch (e) {}

        commit(LOGOUT);
    },
};

const storeAuth = {
    state,
    actions,
    mutations,
};

export default storeAuth;
