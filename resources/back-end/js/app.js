require('./bootstrap.js');

import axios from 'axios';
axios.defaults.baseURL = '/api/v0/';

import Vue from 'vue';

import App from '*/App.vue';
import router from '*/routes';
import store from '*/store';

import VueI18n from 'vue-i18n';
import messages from '*/i18n';
Vue.use(VueI18n);

import Toaster from 'v-toaster';
Vue.use(Toaster, { timeout: 5000 });

import VueSwal from 'vue-swal';
Vue.use(VueSwal);

if (store.state.storeAuth.token) {
    let existed_token = JSON.parse(store.state.storeAuth.token);
    axios.defaults.headers.common[
        'Authorization'
    ] = `${existed_token.token_type} ${existed_token.access_token}`;
}

const i18n = new VueI18n({
    locale: 'en', // set locale: en, vi ...
    messages, // set locale messages
});

new Vue({
    router: router,
    store: store,
    i18n: i18n,
    render: (h) => h(App),
}).$mount('#app');