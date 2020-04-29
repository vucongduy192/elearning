import axios from 'axios';

const ADMIN_MODULE_SHOW = 'module/show';

const state = {
    edit: {
        data: {},
    },
};

const mutations = {
    [ADMIN_MODULE_SHOW](state, { data }) {
        return (state.edit.data = data);
    },
};

const actions = {
    async actionModuleShow({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get(`/modules/${id}`);
            commit(ADMIN_MODULE_SHOW, { data: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeModule = {
    state,
    actions,
    mutations,
};

export default storeModule;
