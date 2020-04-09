const ADMIN_LOADING = 'admin_loading';

const state = {
    loading: {
        show: false,
    },
};

const mutations = {
    [ADMIN_LOADING](state, { loading }) {
        state.loading = loading;
    },
};

const actions = {
    setAdminLoading({ commit }, loading) {
        commit(ADMIN_LOADING, { loading });
    },
};

const storeLoading = {
    state,
    actions,
    mutations,
};

export default storeLoading;
