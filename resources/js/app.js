/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './components/App.vue';

import moment from 'moment';
import VueProgressBar from 'vue-progressbar';

const options = {
    color: '#fff',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
};

Vue.use(VueProgressBar, options);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const routes = [
    { path: '/home', component: require('./components/Home.vue').default },
    { path: '/about', component: require('./components/About.vue').default },
    { path: '/posts', component: require('./components/Posts.vue').default }
];

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history'
});

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.filter('dateFormat', (date) => {
    return moment(date).format('MMMM D, YYYY');
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
