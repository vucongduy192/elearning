import axios from 'axios';

const FETCH_CATEGORY = 'category/fetch_list';
const ADMIN_CATEGORY_SHOW = 'category/show';
const ADMIN_CATEGORY_DELETE = 'category/delete';

const state = {
    listFetch: {},
    edit: {
        data: {},
    },
};

const mutations = {
    [FETCH_CATEGORY](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [ADMIN_CATEGORY_SHOW](state, { data }) {
        return (state.edit.data = data);
    },
    [ADMIN_CATEGORY_DELETE](state, { id }) {
        return (state.listFetch.data = state.listFetch.data.filter((p) => p.id !== id));
    },
};

const actions = {
    async actionFetchCategory({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            let url = `/categories?${$.param(params)}`;
            const { data } = await axios.get(url);
            commit(FETCH_CATEGORY, { listFetch: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionCategoryShow({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get(`/categories/${id}`);
            commit(ADMIN_CATEGORY_SHOW, { data: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionCategoryDelete({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            console.log('abc');
            const { data } = await axios.delete(`/categories/${id}`);
            commit(ADMIN_CATEGORY_DELETE, { id });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeCategory = {
    state,
    actions,
    mutations,
};

export default storeCategory;
