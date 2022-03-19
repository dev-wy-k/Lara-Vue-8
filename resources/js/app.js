require('./bootstrap');
import { Form } from 'vform';
import { HasError, AlertError } from 'vform/src/components/bootstrap5';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import VueProgressBar from 'vue-progressbar';
import VueLoading from 'vue-loading-overlay';
import Vue from 'vue';


window.Form = Form;
window.HasError = HasError;
window.AlertError = AlertError;
window.Vue = require('vue').default;
window.Swal = Swal;

const options = {
    color: '#9d6b53',
    failedColor: '#a4161a',
    thickness: '5px',
}

Vue.use(VueProgressBar, options);
Vue.use(VueLoading, {
    color: '#9d6b53',
    loader: 'Bars',
    width: 80,
    height: 80
});

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);


window.Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})


const app = new Vue({
    el: '#app',
});