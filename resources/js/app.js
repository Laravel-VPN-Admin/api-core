require('./bootstrap');

// Plugins
import Vue       from 'vue';
import VueRouter from 'vue-router';
import VueApollo from 'vue-apollo';
import Cookies   from 'js-cookie';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Configs
import apolloClient from "./apollo";
import store        from "./store";
import routes       from './routes';

// Main components
import App from "./components/App";

// glocal constant
window.apollo = apolloClient;

// Basic uses
Vue.use(VueRouter);
Vue.use(VueApollo);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

const apolloProvider = new VueApollo({
  defaultClient: apolloClient,
});

// Localization
Vue.filter('trans', (...args) => {
  return typeof window.Lang !== 'undefined' ? window.Lang.get(...args) : '';
});

// Plural support in localization
Vue.filter('trans_choice', (...args) => {
  return typeof window.Lang !== 'undefined' ? window.Lang.choice(...args) : '';
});

Vue.prototype.trans = (key, replacements, locale) => {
  return typeof window.Lang !== 'undefined' ? window.Lang.get(key, replacements, locale) : '';
};

// Preconfigure Vue-Router
export const router = new VueRouter({
  // mode: 'history',
  linkActiveClass:      "active",
  linkExactActiveClass: "active",
  routes // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
  const token = Cookies.get('token');
  if (!store.state.token && !token && to.name !== 'login') {
    next({name: 'login'});
  } else {
    if (!store.state.token) {
      store.commit('SET_TOKEN', token);
    }
    next();
  }
});

export const app = new Vue({
  store,
  router,
  apolloProvider,
  components: {
    App
  }
}).$mount("#app");
