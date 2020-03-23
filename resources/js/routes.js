import Vue from 'vue';
import VueRouter from 'vue-router';

import Welcome from "./views/Home";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Welcome
        }
    ]
});

export default router
