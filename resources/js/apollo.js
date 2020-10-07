import ApolloClient      from 'apollo-boost'
import { HttpLink }      from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';
import EchoLink          from './echo.link';
import { ApolloLink }    from "apollo-link";

const echoLink = new EchoLink();
export default new ApolloClient({
  // Provide the URL to the API server.
  link: ApolloLink.from([echoLink, new HttpLink({uri: '/graphql'})]),

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
