require('./bootstrap');

window.Vue = require('vue');

// Configs
import store  from "./store";
import routes from './routes';

// Plugins
import VueApollo from 'vue-apollo';
import VueRouter from 'vue-router';

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

router.beforeEach((to, from, next) => {
  if (!store.state.token && to.name !== 'login') {
    next({name: 'login'});
  } else {
    next();
  }
});

const app = new Vue({
  store,
  router,
  components: {
    App
  }
}).$mount("#app");
