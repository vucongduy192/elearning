import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
import store from '*/store';

import Main from '*/components/Main';
import Dashboard from '*/modules/dashboard/views/Dashboard';
import Login from '*/modules/auth/views/Login';

import Config from '*/modules/config/views/Config';

import Category from '*/modules/category/views/Category';
import CategoryAdd from '*/modules/category/views/CategoryAdd';
import CategoryEdit from '*/modules/category/views/CategoryEdit';

import Rule from '*/modules/rule/views/Rule';
import RuleAdd from '*/modules/rule/views/RuleAdd';
import RuleEdit from '*/modules/rule/views/RuleEdit';
import RuleMatrix from '*/modules/rule/views/RuleMatrix';

import User from '*/modules/user/views/User';
import Teacher from '*/modules/user/views/Teacher';
import Student from '*/modules/user/views/Student';
import UserAdd from '*/modules/user/views/UserAdd';
import UserEdit from '*/modules/user/views/UserEdit';

import Course from '*/modules/course/views/Course';
import CourseAdd from '*/modules/course/views/CourseAdd';
import CourseEdit from '*/modules/course/views/CourseEdit';

import ModuleEdit from '*/modules/module/views/ModuleEdit';

import Enroll from '*/modules/enroll/views/Enroll';
import EnrollMatrix from '*/modules/enroll/views/EnrollMatrix';

import Blog from '*/modules/blog/views/Blog';
import BlogAdd from '*/modules/blog/views/BlogAdd';
import BlogEdit from '*/modules/blog/views/BlogEdit';

import Log from '*/modules/log/views/Log';

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/admin',
            name: 'main',
            component: Main,
            redirect: { name: 'main.dashboard' },
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'main.dashboard',
                    component: Dashboard,
                },
                {
                    path: 'configs',
                    name: 'main.config',
                    component: Config,
                },
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
                {
                    path: 'users',
                    component: {
                        render(c) {
                            return c('router-view');
                        },
                    },
                    children: [
                        {
                            path: 'admin',
                            name: 'main.user',
                            component: User,
                        },
                        {
                            path: 'teacher',
                            name: 'main.teacher',
                            component: Teacher,
                        },
                        {
                            path: 'student',
                            name: 'main.student',
                            component: Student,
                        },
                        {
                            path: 'add',
                            name: 'main.user.add',
                            component: UserAdd,
                        },
                        {
                            path: 'edit/:id',
                            name: 'main.user.edit',
                            component: UserEdit,
                        },
                    ],
                },
                {
                    path: 'courses',
                    component: {
                        render(c) {
                            return c('router-view');
                        },
                    },
                    children: [
                        {
                            path: '',
                            name: 'main.course',
                            component: Course,
                        },
                        {
                            path: 'add',
                            name: 'main.course.add',
                            component: CourseAdd,
                        },
                        {
                            path: 'edit/:id',
                            name: 'main.course.edit',
                            component: CourseEdit,
                        },
                    ],
                },
                {
                    path: 'modules',
                    component: {
                        render(c) {
                            return c('router-view');
                        },
                    },
                    children: [
                        {
                            path: 'edit/:id',
                            name: 'main.module.edit',
                            component: ModuleEdit,
                        },
                    ],
                },
                {
                    path: 'enrolls',
                    component: {
                        render(c) {
                            return c('router-view');
                        },
                    },
                    children: [
                        {
                            path: '',
                            name: 'main.enroll',
                            component: Enroll,
                        },
                        {
                            path: 'matrix',
                            name: 'main.enroll.matrix',
                            component: EnrollMatrix,
                        },
                    ],
                },
                {
                    path: 'blogs',
                    component: {
                        render(c) {
                            return c('router-view');
                        },
                    },
                    children: [
                        {
                            path: '',
                            name: 'main.blog',
                            component: Blog,
                        },
                        {
                            path: 'add',
                            name: 'main.blog.add',
                            component: BlogAdd,
                        },
                        {
                            path: 'edit/:id',
                            name: 'main.blog.edit',
                            component: BlogEdit,
                        },
                    ],
                },
                {
                    path: 'logs',
                    component: {
                        render(c) {
                            return c('router-view');
                        },
                    },
                    children: [
                        {
                            path: '',
                            name: 'main.log',
                            component: Log,
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
            return next({
                path: '/admin/login',
            });
        }
    }

    return next();
});

export default router;
