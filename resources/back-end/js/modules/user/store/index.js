import axios from 'axios';

const FETCH_USER = 'user/fetch_list';
const FETCH_TEACHER = 'teacher/fetch_list';
const FETCH_STUDENT = 'student/fetch_list';
const ADMIN_USER_SHOW = 'user/show';
const ADMIN_USER_DELETE = 'user/delete';

const state = {
    listFetch: {},
    edit: {
        data: {},
    },
};

const mutations = {
    [FETCH_USER](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [FETCH_TEACHER](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [FETCH_STUDENT](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [ADMIN_USER_SHOW](state, { data }) {
        return (state.edit.data = data);
    },
    [ADMIN_USER_DELETE](state, { id }) {
        return (state.listFetch.data = state.listFetch.data.filter((p) => p.id !== id));
    },
};

const actions = {
    async actionFetchUser({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            let url = `/users?${$.param(params)}`;
            const { data } = await axios.get(url);
            commit(FETCH_USER, { listFetch: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionFetchTeacher({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            let url = `/teachers?${$.param(params)}`;
            const { data } = await axios.get(url);
            commit(FETCH_TEACHER, { listFetch: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionFetchStudent({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            let url = `/students?${$.param(params)}`;
            const { data } = await axios.get(url);
            commit(FETCH_TEACHER, { listFetch: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionUserShow({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get(`/users/${id}`);
            commit(ADMIN_USER_SHOW, { data: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionUserDelete({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.delete(`/users/${id}`);
            commit(ADMIN_USER_DELETE, { id });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeUser = {
    state,
    actions,
    mutations,
};

export default storeUser;
