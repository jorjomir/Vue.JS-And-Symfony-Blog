import Vue from 'vue'
import axios from 'axios'
import Vuelidate from 'vuelidate'
//import VueAxios from 'axios'

import App from './App.vue'
import VueRouter from 'vue-router'
import { routes } from './routes'
//import { axiosPlugin } from '@/plugins/axiosPlugin'
import { auth, admin } from '@/services/authService'
import './assets/js/jquery-3.2.1.min.js'
//import './assets/js/popper.js'
import 'bootstrap' 
//import './assets/js/stellar.js'
//import './assets/js/jquery.magnific-popup.min.js'
//import './assets/js/jquery.nice-select.min.js'
//import './assets/js/imagesloaded.pkgd.min.js'
//import './assets/js/isotope-min.js'
//import './assets/js/owl.carousel.min.js'

import 'bootstrap/dist/css/bootstrap.min.css'
//Imported from theme
//import './assets/style.css'
//import './assets/font-awesome.min.css'
//import './assets/owl.carousel.min.css'
//import './assets/magnific-popup.css'
//import './assets/nice-select.css'
//import './assets/main.css'

//import axiosApi from 'axios';

/*const axios = VueAxios.create({
    baseURL:`http://localhost:8000`,
    headers:{ }
});*/

//Use the window object to make it available globally.
//window.axios = axios;

Vue.use(VueRouter)
Vue.use(axios)
Vue.use(Vuelidate)
//Vue.use(axiosPlugin)
Vue.config.productionTip = false
Vue.mixin(auth)
Vue.mixin(admin)

const base = axios.create({
  baseURL: 'http://localhost:8000'
})

Vue.prototype.$http = base

const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location, onResolve, onReject) {
  if (onResolve || onReject) return originalPush.call(this, location, onResolve, onReject)
  return originalPush.call(this, location).catch(err => err)
}
const vueRouter = new VueRouter({
  mode: 'history',
  routes
  });
  
  new Vue({
  el: '#app',
  router: vueRouter,
  render: h => h(App),
  });
