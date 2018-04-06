
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');



//bootstrapvue 
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);
import swal from 'sweetalert2'
Vue.prototype.$swal=swal;




import Router from './routes.js'


import Auth from './Auth.js'
//import Char from './Chart.min.js'
Vue.use(Auth)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app-login', require('./components/Login.vue'));
Vue.component('app-menu', require('./components/TopMenu.vue'));
Vue.component('app-sidebar', require('./components/Sidebar.vue'));
Vue.component('app-content', require('./components/Contents.vue'));
/* Users*/

Vue.component('app-vue', require('./components/App.vue'));
Vue.component('app-addusers', require('./components/User/AddUsers.vue'));
Vue.component('app-affusers', require('./components/User/AffUsers.vue'));
Vue.component('app-edituser', require('./components/User/EditUser.vue'));
Vue.component('app-userconnect', require('./components/User/UserConnect.vue'));
/* Compagnies*/
Vue.component('app-addcompagnie', require('./components/Compagnie/AddCompagnie.vue'));
Vue.component('app-affcompagnie', require('./components/Compagnie/AffCompagnie.vue'));
Vue.component('app-editcompagnie', require('./components/Compagnie/EditCompagnie.vue'));
/* Devis  */
Vue.component('app-adddevis', require('./components/Devis/AddDevis.vue'));
Vue.component('app-affdevis', require('./components/Devis/AffDevis.vue'));
Vue.component('app-detailsdevis', require('./components/Devis/DevisDetails.vue'));
Vue.component('app-editdevis', require('./components/Devis/EditDevis.vue'));


// afficher un nombre de phrase limité 
/*Vue.filter('readMore', function (text, length, suffix) {
    return text.substring(0, length) + suffix;
});*/


/*import jquery from 'jquery'
global.jquery = jquery
global.$ = jquery*/

Router.beforeEach(

    (to,from,next) => {
        if(to.matched.some(record => record.meta.SuperAdmin) ){
            
            Promise.resolve(Vue.auth.getProfile()).then(function(value){
               
                if(value){
                    next({
                        path:'/'
                    })
                }
                else next()
            });
        
        

        }else next()
    }
)
const app = new Vue({
    el: '#app',
    router: Router,
   
            
  
});
