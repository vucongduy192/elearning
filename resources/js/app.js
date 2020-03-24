/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap.js'
import Vue from 'vue'

import './assets/js/jquery-3.2.1.min.js'
import './assets/js/bootstrap4/popper.js'
import './assets/js/bootstrap4/bootstrap.min.js'
import './assets/plugins/OwlCarousel2-2.2.1/owl.carousel.js'
import './assets/plugins/easing/easing.js'
import './assets/js/custom.js'

import App from './layouts/App.vue'
import router from "./routes";

new Vue({
    router: router,
    render: (h) => h(App)
}).$mount('#app');
