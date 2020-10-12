import { ApolloClient }   from 'apollo-client';
import { createHttpLink } from 'apollo-link-http';
import { InMemoryCache }  from 'apollo-cache-inmemory'
import { ApolloLink }     from 'apollo-link';
import { setContext }     from "apollo-link-context";
import Cookies            from 'js-cookie';

// pusher.js
import Pusher     from "pusher-js";
import PusherLink from './pusher-link';

const pusherLink = new PusherLink({
  pusher: new Pusher('ec4590b10c250426b9d1', {
    cluster:      'eu',
    authEndpoint: `/graphql/subscriptions/auth`,
  })
});

const authLink = setContext(async (_, {headers}) => {
  const token = Cookies.get('token');
  return {
    headers: {
      ...headers,
      authorization: token ? `Bearer ${token}` : "",
    }
  }
});

export default new ApolloClient({
  // Provide the URL to the API server.
  link: ApolloLink.from([authLink, pusherLink, createHttpLink({uri: '/graphql'})]),

  // Using a cache for fast subsequent queries.
  cache: new InMemoryCache(),
});
