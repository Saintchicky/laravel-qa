/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//On peut appeler le fichier js ici
require('./fontawesome');

window.Vue = require('vue');

//Pop up JS 
import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';
import Autorization from './authorization/authorize';
// pour les routes js
import router from './router';
// le loading 
import Spinner from './components/Spinner.vue';

Vue.use(VueIziToast);
Vue.use(Autorization);



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('user-info', require('./components/UserInfo.vue').default);
// Vue.component('vote', require('./components/Vote.vue').default);
// Vue.component('question-page', require('./pages/QuestionPage.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('spinner',Spinner);
const app = new Vue({
    el: '#app',
    data: {
        loading: false
    },
    // pour faire jouer le spinner intercepte la requête et la réponse
    created () {
        // Add a request interceptor
        axios.interceptors.request.use((config) => {
            this.loading = true
            return config;
        }, (error) => {
            this.loading = false
            return Promise.reject(error);
        });

        // Add a response interceptor
        axios.interceptors.response.use((response) => {
            this.loading = false
            return response;
        }, (error) => {
            this.loading = false
            return Promise.reject(error);
        });
    },
    router // routes js
});
