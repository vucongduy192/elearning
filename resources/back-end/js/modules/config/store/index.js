import axios from 'axios';

const FETCH_CONFIG = 'config/fetch';
const FETCH_LANGS = 'config/name_convert';

const state = {
    config: {},
    langs: [],
};

const mutations = {
    [FETCH_CONFIG](state, { config }) {
        return (state.config = config);
    },
    [FETCH_LANGS](state, { langs }) {
        return (state.langs = langs);
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

    async actionFetchLangs({ commit }, { vue }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get('/configs/get_name_convert');
            commit(FETCH_LANGS, { langs: data });
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
