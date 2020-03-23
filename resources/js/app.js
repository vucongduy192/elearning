/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap.js'
import Vue from 'vue'

import Routes from './routes.js'
import App from './layouts/App.vue'

const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App)
});

export default app;