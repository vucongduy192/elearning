import axios from 'axios';

const FETCH_BLOG = 'blog/fetch_list';
const ADMIN_BLOG_SHOW = 'blog/show';
const ADMIN_BLOG_DELETE = 'blog/delete';

const state = {
    listFetch: {},
    edit: {
        data: {},
    },
};

const mutations = {
    [FETCH_BLOG](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [ADMIN_BLOG_SHOW](state, { data }) {
        return (state.edit.data = data);
    },
    [ADMIN_BLOG_DELETE](state, { id }) {
        return (state.listFetch.data = state.listFetch.data.filter((p) => p.id !== id));
    },
};

const actions = {
    async actionFetchBlog({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            let url = `/blogs?${$.param(params)}`;
            const { data } = await axios.get(url);
            commit(FETCH_BLOG, { listFetch: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionBlogShow({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get(`/blogs/${id}`);
            commit(ADMIN_BLOG_SHOW, { data: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionBlogDelete({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.delete(`/blogs/${id}`);
            commit(ADMIN_BLOG_DELETE, { id });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeBlog = {
    state,
    actions,
    mutations,
};

export default storeBlog;
