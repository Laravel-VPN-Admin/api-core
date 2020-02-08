import Vue  from "vue";
import Vuex from "vuex";
import gql  from 'graphql-tag';

import { router } from "./app";
import GraphQL    from './graphql';

Vue.use(Vuex);

const store = new Vuex.Store({

  state: {
    users:   {},
    servers: {},
    groups:  {},
    logs:    {},
  },

  mutations: {
    SET_USERS(state, items) {
      state.users = items;
    },
    SET_SERVERS(state, items) {
      state.servers = items;
    },
    SET_GROUPS(state, items) {
      state.groups = items;
    },
    SET_LOGS(state, items) {
      state.logs = items;
    },
  },

  actions: {

    /**
     * Get list of all available groups
     *
     * @param {Number} page
     * @param {Number} first
     * @returns {Promise<void>}
     */
    async getGroups({commit, state}, page = 1, first = 10) {
      const response = await GraphQL.query({
        query:     gql`
          query Groups($page: Int!, $first: Int!) {
            groups(page: $page, first: $first) {
              data {
                id
                name
                object
                created_at
                updated_at
                users {
                  id
                }
                servers {
                  id
                }
              }
              paginatorInfo {
                hasMorePages
              }
            }
          }
        `,
        variables: {
          page,
          first
        }
      });

      commit('SET_GROUPS', response.data.groups.data);
    },

    /**
     * Get list of all available servers
     *
     * @param {Number} page
     * @param {Number} first
     * @returns {Promise<void>}
     */
    async getServers({commit, state}, page = 1, first = 10) {
      const response = await GraphQL.query({
        query:     gql`
          query Servers($page: Int!, $first: Int!) {
            servers(page: $page, first: $first) {
              data {
                id
                hostname
                ipv4
                ipv6
                created_at
                updated_at
                groups {
                  id
                }
                users {
                  id
                }
              }
              paginatorInfo {
                hasMorePages
              }
            }
          }
        `,
        variables: {
          page,
          first
        }
      });

      commit('SET_SERVERS', response.data.servers.data);
    },

    /**
     * Get list of all available users
     *
     * @param {Number} page
     * @param {Number} first
     * @returns {Promise<void>}
     */
    async getUsers({commit, state}, page = 1, first = 10) {
      const response = await GraphQL.query({
        query:     gql`
          query Users($page: Int!, $first: Int!) {
            users(page: $page, first: $first) {
              data {
                id
                name
                created_at
                updated_at
                groups {
                  id
                }
              }
              paginatorInfo {
                hasMorePages
              }
            }
          }
        `,
        variables: {
          page,
          first
        }
      });

      commit('SET_USERS', response.data.users.data);
    },


    /**
     * Get list of all available logs
     *
     * @param {Number} page
     * @param {Number} first
     * @returns {Promise<void>}
     */
    async getLogs({commit, state}, page = 1, first = 10) {
      const response = await GraphQL.query({
        query:     gql`
          query Logs($page: Int!, $first: Int!) {
            logs(page: $page, first: $first) {
              data {
                id
                code
                message
                created_at
                updated_at
                user {
                  id
                  name
                }                
                server {
                  id
                  hostname
                }
              }
              paginatorInfo {
                hasMorePages
              }
            }
          }
        `,
        variables: {
          page,
          first
        }
      });

      commit('SET_LOGS', response.data.logs.data);
    },

  }

});

export default store;
