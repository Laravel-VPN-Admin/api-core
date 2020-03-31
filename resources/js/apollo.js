import ApolloClient      from 'apollo-boost'
import { HttpLink }      from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';

export default new ApolloClient({
  // Provide the URL to the API server.
  link: new HttpLink({uri: '/graphql'}),

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
