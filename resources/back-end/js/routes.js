import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
import store from '*/store';

import Main from '*/components/Main';
import Login from '*/modules/auth/views/Login';
import Category from '*/modules/category/views/Category';
import CategoryAdd from '*/modules/category/views/CategoryAdd';
import CategoryEdit from '*/modules/category/views/CategoryEdit';

import Rule from '*/modules/rule/views/Rule';
import RuleAdd from '*/modules/rule/views/RuleAdd';
import RuleEdit from '*/modules/rule/views/RuleEdit';
import RuleMatrix from '*/modules/rule/views/RuleMatrix';

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
                {
                    path: 'rules',
                    component: {
                        render(c) {
                            return c('router-view');
                        },
                    },
                    children: [
                        {
                            path: '',
                            name: 'main.rule',
                            component: Rule,
                        },
                        {
                            path: 'add',
                            name: 'main.rule.add',
                            component: RuleAdd,
                        },
                        {
                            path: 'edit/:id',
                            name: 'main.rule.edit',
                            component: RuleEdit,
                        },
                        {
                            path: 'matrix',
                            name: 'main.rule.matrix',
                            component: RuleMatrix,
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

router.beforeEach(async (to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (store.state.storeAuth.token) {
            try {
                await store.dispatch('fetchUser');
            } catch (e) {}
        } else {
            return next({ name: 'login' });
        }
    }

    return next();
});

export default router;
