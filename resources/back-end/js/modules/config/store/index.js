import axios from 'axios';

const FETCH_CONFIG = 'config/fetch';

const state = {
    config: {},
};

const mutations = {
    [FETCH_CONFIG](state, { config }) {
        return (state.config = config);
    },
};

const actions = {
    async actionFetchConfig({ commit }, { vue }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get('/configs');
            commit(FETCH_CONFIG, { config: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeConfig = {
    state,
    actions,
    mutations,
};

export default storeConfig;