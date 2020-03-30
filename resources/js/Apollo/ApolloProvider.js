import VueApollo  from 'vue-apollo';
import apolloClient  from './ApolloClient';

export default new VueApollo({
  // Default client
  defaultClient: apolloClient,
  // Default 'apollo' definition
  defaultOptions: {
    // See 'apollo' definition
    // For example: default query options
    $query: {
      loadingKey: 'loading',
      fetchPolicy: 'cache-and-network',
    },
  },

  errorHandler (error) {
    console.log('Global error handler')
    console.error(error)
  },
  prefetch: Boolean,
});