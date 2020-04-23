import axios from 'axios';

const FETCH_ENROLL = 'enroll/fetch_list';
const ADMIN_ENROLL_SHOW = 'enroll/show';

const state = {
    listFetch: {},
    edit: {
        data: {},
    },
};

const mutations = {
    [FETCH_ENROLL](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [ADMIN_ENROLL_SHOW](state, { data }) {
        return (state.edit.data = data);
    },
};

const actions = {
    async actionFetchEnroll({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            let url = `/enrolls?${$.param(params)}`;
            const { data } = await axios.get(url);
            commit(FETCH_ENROLL, { listFetch: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionEnrollShow({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get(`/enrolls/${id}`);
            commit(ADMIN_ENROLL_SHOW, { data: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeEnroll = {
    state,
    actions,
    mutations,
};

export default storeEnroll;
