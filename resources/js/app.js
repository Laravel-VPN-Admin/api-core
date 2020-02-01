require('./bootstrap');

window.Vue = require('vue');

// Plugins
import ApolloClient from 'apollo-boost'
import VueApollo    from 'vue-apollo'

// Main components
import PaginatorGroups from "./components/PaginatorGroups";
import MutatorGroup    from "./components/MutatorGroup";
import App             from "./components/App";

// Basic uses
Vue.use(VueApollo);

// Preconfigure Apollo client
const apolloProvider = new VueApollo({
  defaultClient: new ApolloClient({
    uri: '/graphql'
  })
});

const app = new Vue({
  el:         '#app',
  apolloProvider,
  components: {
    App
  }
});
