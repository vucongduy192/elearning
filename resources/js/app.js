/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap.js'
import Vue from 'vue'

import '@/js/jquery-3.2.1.min.js'
import '@/styles/bootstrap4/popper.js'
import '@/styles/bootstrap4/bootstrap.min.js'
import '@/plugins/OwlCarousel2-2.2.1/owl.carousel.js'
import '@/plugins/easing/easing.js'
import '@/js/custom.js'

import Routes from './routes.js'
import App from './layouts/App.vue'

const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App)
});

export default app;
