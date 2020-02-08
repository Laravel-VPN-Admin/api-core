require('./bootstrap');

window.Vue = require('vue');

// Configs
import routes             from './routes.js'
import { apolloProvider } from './apollo.js'

// Plugins
import VueApollo from 'vue-apollo'
import VueRouter from 'vue-router'

// Main components
import App from "./components/App";

// Basic uses
Vue.use(VueApollo);
Vue.use(VueRouter);

// Preconfigure Vue-Router
const router = new VueRouter({
  // mode: 'history',
  linkActiveClass:      "active",
  linkExactActiveClass: "active",
  routes // short for `routes: routes`
});

const app = new Vue({
  apolloProvider,
  router,
  components: {
    App
  }
}).$mount("#app");
