import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const Store = new Vuex.Store({
    state: {
        isLoggedIn: !!localStorage.getItem('token'),
        token: localStorage.getItem('token'),
        customer: JSON.parse(localStorage.getItem('customer'))
    },
    mutations: {
        CustomerLoggedIn(state, data) {
            state.isLoggedIn = true;
            state.token = data.token;
            localStorage.setItem('token', data.token);
            state.customer = data.customer;
            localStorage.setItem('customer', JSON.stringify(data.customer));
        },
        updateProfile(state, data) {
            state.customer = data.customer;
            localStorage.setItem('customer', JSON.stringify(data.customer));
        },
        CustomerLoggedOut(state) {
            state.isLoggedIn = false;
            localStorage.removeItem('token');
            localStorage.removeItem('customer');
        }
    }
});

export default Store;