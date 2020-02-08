require('./bootstrap');

window.Vue = require('vue');

// Configs
import routes from './routes.js'
import { apolloProvider } from './apollo.js'

// Plugins
import VueApollo    from 'vue-apollo'
import VueRouter    from 'vue-router'
import VueAuth      from './plugins/vue-auth-graphql'

// Main components
import PaginatorGroups from "./components/PaginatorGroups";
import MutatorGroup    from "./components/MutatorGroup";
import App             from "./components/App";

// Basic uses
Vue.use(VueAuth);
Vue.use(VueApollo);
Vue.use(VueRouter);

// Preconfigure Vue-Router
const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
  el:         '#app',
  apolloProvider,
  router,
  components: {
    App
  }
});
