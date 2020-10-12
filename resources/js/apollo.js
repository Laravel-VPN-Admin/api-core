import {ApolloClient}  from 'apollo-client';
import {HttpLink}      from 'apollo-link-http';
import {InMemoryCache} from 'apollo-cache-inmemory';
import {ApolloLink}    from 'apollo-link';
import {setContext}    from "apollo-link-context";

// pusher.js
import Pusher     from "pusher-js";
import PusherLink from './pusher-link';

const token = localStorage.getItem('token');

const pusherLink = new PusherLink({
    pusher: new Pusher('ec4590b10c250426b9d1', {
        cluster: 'eu',
        authEndpoint: `/graphql/subscriptions/auth`,
        auth: {
            headers: {
                authorization: token ? `Bearer ${token}` : null,
            },
        },
    })
});

const authLink = setContext((_, {headers}) => {
    return {
        headers: {
            ...headers,
            authorization: token ? `Bearer ${token}` : "",
        }
    }
});

export default new ApolloClient({
    // Provide the URL to the API server.
    link: ApolloLink.from([authLink, pusherLink, new HttpLink({uri: '/graphql'})]),

    // Using a cache for fast subsequent queries.
    cache: new InMemoryCache(),
});