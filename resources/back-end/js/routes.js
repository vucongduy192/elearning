import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
import store from '*/store';

import Main from '*/components/Main';
import Login from '*/modules/auth/views/Login';
import Category from '*/modules/category/views/Category';
import CategoryAdd from '*/modules/category/views/CategoryAdd';
import CategoryEdit from '*/modules/category/views/CategoryEdit';

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/admin',
            name: 'main',
            component: Main,
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'categories',
                    component: {
                        render(c) {
                            return c('router-view');
                        },
                    },
                    children: [
                        {
                            path: '',
                            name: 'main.category',
                            component: Category,
                        },
                        {
                            path: 'add',
                            name: 'main.category.add',
                            component: CategoryAdd,
                        },
                        {
                            path: 'edit/:id',
                            name: 'main.category.edit',
                            component: CategoryEdit,
                        },
                    ],
                },
            ],
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
        if (store.state.storeAuth.token === undefined) {
            return next({ path: '/admin/login' });
        }
    }

    return next();
});

export default router;
