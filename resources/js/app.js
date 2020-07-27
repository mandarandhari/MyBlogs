/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import App from './components/App.vue';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import store from './store';

Vue.use(VueRouter);

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
    { path: '/home', name: 'home', component: require('./components/Home.vue').default },
    { path: '/about', name: 'about', component: require('./components/About.vue').default },
    { path: '/posts', name: 'posts', component: require('./components/Posts.vue').default },
    { path: '/contact', name: 'contact', component: require('./components/Contact.vue').default },
    { path: '/post/:blogUrl', name: 'blog', component: require('./components/Post.vue').default },
    { path: '/signup', name: 'signup', component: require('./components/auth/Signup.vue').default },
    { path: '/signin', name: 'signin', component: require('./components/auth/Signin.vue').default },
    { path: '/profile', name: 'profile', component: require('./components/auth/Profile.vue').default },
    { path: '/payment', name: 'payment', component: require('./components/auth/Payment.vue').default }
];

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    if ( ( to.path == '/signin' || to.path == '/signup' ) && store.state.isLoggedIn ) {
        next('/home');
    }

    if ( to.path == '/profile' && !store.state.isLoggedIn ) {
        next('/home');
    }

    if ( to.path == '/payment' && (!store.state.isLoggedIn || store.state.customer.is_paid == 'yes')) {
        next('/home');
    }

    next();
})

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
    store,
    render: h => h(App)
});
