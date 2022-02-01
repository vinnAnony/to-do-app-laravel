//require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('guzzler', require('./components/Guzzler.vue').default);


const app = new Vue({
    el: '#app',
});
