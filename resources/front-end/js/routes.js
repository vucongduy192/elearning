import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from "./views/Home";
import Courses from "./views/Courses";
import Professors from "./views/Professors";
import Course_Details from "./views/Course_Details";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/courses',
            name: 'courses',
            component: Courses
        },
        {
            path: '/course_details',
            name: 'course_details',
            component: Course_Details
        },
        {
            path: '/professors',
            name: 'professors',
            component: Professors
        }
    ]
});

export default router;
