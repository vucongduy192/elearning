import Vue from 'vue';
import Vuex from 'vuex';

import storeAuth from '*/modules/auth/store';
import storeLoading from '*/modules/loading/store';
import storeCategory from '*/modules/category/store';
import storeRule from '*/modules/rule/store';
import storeUser from '*/modules/user/store';
import storeCourse from '*/modules/course/store';
import storeModule from '*/modules/module/store';
import storeEnroll from '*/modules/enroll/store';
import storeConfig from '*/modules/config/store';
import storeBlog from '*/modules/blog/store';
import storeNotify from '*/modules/notify/store';
import storeDashboard from '*/modules/dashboard/store';

Vue.use(Vuex);

const storeMain = {
    state: {
        breadcrumb: {
            'main.dashboard': 'Dashboard',
            'main.config': 'Config',
            'main.category': 'Category',
            'main.category.add': 'Add category',
            'main.category.edit': 'Edit category',
            'main.rule': 'Rule',
            'main.rule.add': 'Add rule',
            'main.rule.edit': 'Edit rule',
            'main.user': 'User',
            'main.user.add': 'Add user',
            'main.user.edit': 'Edit user',
            'main.teacher': 'Teacher',
            'main.student': 'Student',
            'main.course': 'Course',
            'main.course.add': 'Add course',
            'main.course.edit': 'Edit course',
            'main.enroll': 'Enroll',
            'main.blog': 'Blog',
            'main.blog.add': 'Add blog',
            'main.blog.edit': 'Edit blog',
        },
    },
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
        storeModule,
        storeEnroll,
        storeConfig,
        storeBlog,
        storeNotify,
        storeDashboard,
    },
});
