/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import App from './views/App';
import router from './router';
import store from './store';
import i18n from './lang';
import './permission';

import Vue from 'vue';
const EventBus = new Vue();
export default EventBus;
import Axios from 'axios';
Vue.config.productionTip = false;
Vue.prototype.$http = Axios;

import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';

require('./bootstrap');

import Paginate from 'vuejs-paginate';
Vue.component('paginate', Paginate);

import FunctionalCalendar from 'vue-functional-calendar';
Vue.use(FunctionalCalendar, {
  dayNames: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
});

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.config.productionTip = false;

new Vue({
  el: '#app',
  router,
  store,
  i18n,

  render: h => h(App),
});
