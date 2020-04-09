import Vue from 'vue';
import Vuex from 'vuex';

import storeAuth from '*/modules/auth/store';
import storeLoading from '*/modules/loading/store';
import storeCategory from '*/modules/category/store';

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
    },
});
