import { ApolloClient }  from 'apollo-client';
import { HttpLink }      from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';
import { ApolloLink }    from 'apollo-link';
import { setContext }    from "apollo-link-context";
import EchoLink          from './echo.link';

const echoLink = new EchoLink();

const authLink = setContext((_, {headers}) => {
    // get the authentication token from local storage if it exists
    const token = localStorage.getItem('token');
    // return the headers to the context so httpLink can read them
    return {
        headers: {
            ...headers,
            authorization: token ? `Bearer ${token}` : "",
        }
    }
});

export default new ApolloClient({
    // Provide the URL to the API server.
    link: ApolloLink.from([authLink, echoLink, new HttpLink({uri: '/graphql'})]),

    // Using a cache for fast subsequent queries.
    cache: new InMemoryCache(),
});
