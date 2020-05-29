import axios from 'axios';

const FETCH_CHART = 'dashboard/fetch';

const state = {
    top_courses: [],
    best_professors: [],
};

const mutations = {
    [FETCH_CHART](state, { data }) {
        state.top_courses = data.top_courses;
        state.best_professors = data.best_professors;
        return;
    },
};

const actions = {
    async actionFetchChart({ commit }, { vue }) {
        vue.$store.dispatch('setAdminMainLoading', { show: true });
        try {
            const { data } = await axios.get('/dashboards');
            commit(FETCH_CHART, { data: data });
        } catch (error) {}
        vue.$store.dispatch('setAdminMainLoading', { show: false });
    },
};

const storeDashboard = {
    state,
    actions,
    mutations,
};

export default storeDashboard;
