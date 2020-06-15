import axios from 'axios';

const FETCH_ENROLL = 'enroll/fetch_list';
const ADMIN_ENROLL_SHOW = 'enroll/show';
const FETCH_RECOMMEND = 'enroll/fetch_recommend';

const state = {
    listFetch: {},
    edit: {
        data: {},
    },
    recommends: {},
};

const mutations = {
    [FETCH_ENROLL](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [ADMIN_ENROLL_SHOW](state, { data }) {
        return (state.edit.data = data);
    },
    [FETCH_RECOMMEND](state, { data }) {
        return (state.recommends = data);
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

    async actionFetchRecommend({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            let url = `/recommend_progress?${$.param(params)}`;
            const { data } = await axios.get(url);
            commit(FETCH_RECOMMEND, { data: data });
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
