import Vue from 'vue'
import axios from 'axios'
//import VueAxios from 'axios'

import App from './App.vue'
import VueRouter from 'vue-router'
import { routes } from './routes'
//import { axiosPlugin } from '@/plugins/axiosPlugin'
import { auth } from '@/services/authService'
import 'bootstrap' 
import 'bootstrap/dist/css/bootstrap.min.css'

//import axiosApi from 'axios';

/*const axios = VueAxios.create({
    baseURL:`http://localhost:8000`,
    headers:{ }
});*/

//Use the window object to make it available globally.
//window.axios = axios;

Vue.use(VueRouter)
Vue.use(axios)
//Vue.use(axiosPlugin)
Vue.config.productionTip = false
Vue.mixin(auth)

const base = axios.create({
  baseURL: 'http://localhost:8000'
})

Vue.prototype.$http = base

const vueRouter = new VueRouter({
  mode: 'history',
  routes
  });
  
  new Vue({
  
  el: '#app',
  
  router: vueRouter,
  
  render: h => h(App)
  
  });
