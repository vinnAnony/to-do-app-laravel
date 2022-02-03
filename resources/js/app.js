//require('./bootstrap');

window.Vue = require('vue').default;
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueSweetalert2);

Vue.component('guzzler', require('./components/Guzzler.vue').default);


const app = new Vue({
    el: '#app',
});
