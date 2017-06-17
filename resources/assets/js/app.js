
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.moment = require('moment');
require('moment/locale/es');
window.Vue = require('vue');

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(require('vue-moment'), { moment });
Vue.use(require('vue2-filters'));
Vue.component('autocomplete', require('vue2-autocomplete-js'));

Vue.component('category', require('./components/Categories.vue'));
Vue.component('create-apart', require('./components/CreateApart.vue'));
Vue.component('create-sale', require('./components/CreateSale.vue'));
Vue.component('products', require('./components/Products.vue'));
Vue.component('sales', require('./components/Sales.vue'));

const app = new Vue({
    el: '#app'
});
