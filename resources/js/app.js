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
import ApolloProvider from "./Apollo/ApolloProvider";

// Basic uses
Vue.use(VueRouter);
Vue.use(VueCookies);
Vue.use(VueApollo);

const apolloProvider = ApolloProvider;

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
  const token = Vue.$cookies.get('token');
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
