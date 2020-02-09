require('./bootstrap');

window.Vue = require('vue');

// Configs
import store  from "./store";
import routes from './routes';

// Plugins
import Vue        from 'vue';
import VueApollo  from 'vue-apollo';
import VueRouter  from 'vue-router';
import VueCookies from 'vue-cookies';

// Main components
import App from "./components/App";

// Basic uses
Vue.use(VueApollo);
Vue.use(VueRouter);
Vue.use(VueCookies);

// Preconfigure Vue-Router
const router = new VueRouter({
  // mode: 'history',
  linkActiveClass:      "active",
  linkExactActiveClass: "active",
  routes // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
  var token = Vue.$cookies.get('token');
  if (!store.state.token && !token && to.name !== 'login') {
    next({name: 'login'});
  } else {
    store.commit('SET_TOKEN', token);
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
