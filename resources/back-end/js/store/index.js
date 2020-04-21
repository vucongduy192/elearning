import Vue from 'vue';
import Vuex from 'vuex';

import storeAuth from '*/modules/auth/store';
import storeLoading from '*/modules/loading/store';
import storeCategory from '*/modules/category/store';
import storeRule from '*/modules/rule/store';
import storeUser from '*/modules/user/store';
import storeCourse from '*/modules/course/store';

Vue.use(Vuex);

const storeMain = {
    state: {},
};

export default new Vuex.Store({
    modules: {
        storeMain,
        storeAuth,
        storeLoading,
        storeCategory,
        storeRule,
        storeUser,
        storeCourse,
    },
});