window.Vue = require('vue');
window.axios = require('axios');

Vue.component('select2', require('./components/select2').default);
Vue.component('location-search', require('./components/location').default);
Vue.component('temperature', require('./components/temperature').default);

const app = new Vue({
    el: '#weather'
});
