require('./bootstrap');

window.Vue = require('vue');

// Configs
import store  from "./store";
import routes from './routes';

import { ApolloLink, Observable } from "apollo-link";
import PusherLink                 from './apollo-link';

// Plugins
import Vue        from 'vue';
import VueApollo  from 'vue-apollo';
import VueRouter  from 'vue-router';
import VueCookies from 'vue-cookies';

// Main components
import App from "./components/App";

// Basic uses
Vue.use(VueRouter);
Vue.use(VueCookies);
Vue.use(VueApollo);

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

const pusherLink = new PusherLink({
  pusher: new Pusher(PUSHER_API_KEY, {
    cluster:      PUSHER_CLUSTER,
    authEndpoint: `${API_LOCATION}/graphql/subscriptions/auth`,
    auth:         {
      headers: {
        authorization: BEARER_TOKEN,
      },
    },
  }),
});

const link = ApolloLink.from([pusherLink, httpLink(`${API_LOCATION}/graphql`)]);

export const app = new Vue({
  store,
  router,
  link,
  components: {
    App
  }
}).$mount("#app");
