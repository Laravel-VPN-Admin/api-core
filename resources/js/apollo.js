import ApolloClient from 'apollo-boost'
import VueApollo    from 'vue-apollo'

// Create the apollo client
export const Apollo = new ApolloClient({
  uri: '/graphql'
});

export const apolloProvider = new VueApollo({
  defaultClient: Apollo
});
