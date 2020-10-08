import VueApollo         from 'vue-apollo';
import ApolloClient      from 'apollo-boost';
import { HttpLink }      from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';
import { split }         from 'apollo-link';
import { WebSocketLink } from 'apollo-link-ws';
import Vue               from "vue";

Vue.use(VueApollo);

const httpLink = new HttpLink({uri: '/graphql'});

// Create the subscription websocket link
const wsLink = new WebSocketLink({
  uri:     'ws://localhost:3000/subscriptions',
  options: {
    reconnect: true,
  },
});

// using the ability to split links, you can send data to each link
// depending on what kind of operation is being sent
const link = split(
  // split based on operation type
  ({query}) => {
    const definition = getMainDefinition(query);
    return definition.kind === 'OperationDefinition' && definition.operation === 'subscription';
  },
  wsLink,
  httpLink
);

export default new ApolloClient({
  // Provide the URL to the API server.
  link: link,

  // Using a cache for fast subsequent queries.
  cache: new InMemoryCache(),

  // Modify the header in simple way
  request: (operation) => {
    const token = localStorage.getItem('token');
    operation.setContext({
      headers: {
        authorization: token ? `Bearer ${token}` : '',
        accept:        'application/json',
      }
    });
  },

  connectToDevTools: true,
});
