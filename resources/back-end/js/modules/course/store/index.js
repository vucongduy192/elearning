import axios from 'axios';

const FETCH_COURSE = 'course/fetch_list';
const ADMIN_COURSE_SHOW = 'course/show';
const ADMIN_COURSE_DELETE = 'course/delete';

const state = {
    listFetch: {},
    edit: {
        data: {},
    },
};

const mutations = {
    [FETCH_COURSE](state, { listFetch }) {
        return (state.listFetch = listFetch);
    },
    [ADMIN_COURSE_SHOW](state, { data }) {
        return (state.edit.data = data);
    },
    [ADMIN_COURSE_DELETE](state, { id }) {
        return (state.listFetch.data = state.listFetch.data.filter((p) => p.id !== id));
    },
};

const actions = {
    async actionFetchCourse({ commit }, { vue, params }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            let url = `/courses?${$.param(params)}`;
            const { data } = await axios.get(url);
            commit(FETCH_COURSE, { listFetch: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionCourseShow({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get(`/courses/${id}`);
            commit(ADMIN_COURSE_SHOW, { data: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },

    async actionCourseDelete({ commit }, { vue, id }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.delete(`/courses/${id}`);
            commit(ADMIN_COURSE_DELETE, { id });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeCourse = {
    state,
    actions,
    mutations,
};

export default storeCourse;
