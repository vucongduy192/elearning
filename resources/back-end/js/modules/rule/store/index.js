import axios from 'axios';

const FETCH_RULE = 'rule/fetch_list';
const ADMIN_RULE_SHOW = 'rule/show';
const ADMIN_RULE_DELETE = 'rule/delete';

const state = {
    listFetch: {},
    edit: {
        data: {},
    },
};

const mutations = {
    [FETCH_RULE](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [ADMIN_RULE_SHOW](state, { data }) {
        return (state.edit.data = data);
    },
    [ADMIN_RULE_DELETE](state, { id }) {
        return (state.listFetch.data = state.listFetch.data.filter((p) => p.id !== id));
    },
};

const actions = {
    async actionFetchRule({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get(`/rules?page=${params.page}`);
            commit(FETCH_RULE, { listFetch: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionRuleShow({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get(`/rules/${id}`);
            commit(ADMIN_RULE_SHOW, { data: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionRuleDelete({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.delete(`/rules/${id}`);
            commit(ADMIN_RULE_DELETE, { id });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeRule = {
    state,
    actions,
    mutations,
};

export default storeRule;
