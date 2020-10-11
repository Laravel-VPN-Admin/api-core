import ApolloClient      from 'apollo-boost'
import { HttpLink }      from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';
import { ApolloLink }    from "apollo-link";
import PusherLink        from "./pusher-link";
import Pusher            from "pusher-js";

const token = localStorage.getItem('token');


console.log(process.env.PUSHER_APP_KEY);
console.log(process.env.PUSHER_APP_CLUSTER);

const pusherLink = new PusherLink({
  pusher: new Pusher('ec4590b10c250426b9d1', {
    cluster: 'eu',
    authEndpoint: `${window.location.hostname}/graphql/subscriptions/auth`,
    auth: {
      headers: {
        authorization: token ? `Bearer ${token}` : null,
      },
    },
  }),
});

export default new ApolloClient({
  // Provide the URL to the API server.
  link: ApolloLink.from([pusherLink, new HttpLink({uri: '/graphql'})]),

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
  }
});