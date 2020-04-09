import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
import store from '*/store';

import Home from '*/components/Home';
import Login from '*/modules/auth/views/Login';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/admin/dashboard',
            name: 'home',
            component: Home,
            meta: { requiresAuth: true },
        },
        {
            path: '/admin/login',
            name: 'login',
            component: Login,
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (store.state.storeAuth.token === null) {
            return next({ path: '/admin/login' });
        }
    }

    return next();
});

export default router;
