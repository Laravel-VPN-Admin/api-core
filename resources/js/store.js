import Vue   from "vue";
import Vuex  from "vuex";
import gql   from 'graphql-tag';
import axios from "axios";

import { router } from "./app";
import GraphQL    from './graphql';

Vue.use(Vuex);

const store = new Vuex.Store({

  state: {
    token:   null,
    users:   {},
    servers: {},
    groups:  {},
    logs:    {},
  },

  mutations: {
    SET_TOKEN(state, items) {
      state.token = items;
    },
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

  getters: {
    /**
     * Check if user has token
     *
     * @returns {boolean}
     */
    isAuthorized: state => {
      return !!state.token;
    }
  },

  actions: {

    /**
     * Submit login request to api server
     *
     * @param {*} data
     */
    async login({commit, state}, data) {
      await axios({
        method: 'POST',
        url:    '/api/login',
        data:   data,
      }).then(response => {
        if (response.data.token) {
          commit("SET_TOKEN", response.data.token);
        }
      }).catch(error => {
        console.error(error);
      });
    },

    /**
     * Get list of all available groups
     *
     * @param {Number} page
     * @param {Number} first
     * @returns {Promise<void>}
     */
    async getGroups({commit, state}, page = 1, first = 100) {
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
                users_count
                servers {
                  id
                }
                servers_count
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
    async getServers({commit, state}, page = 1, first = 100) {
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
                  name
                }
                users {
                  id
                  name
                }
                users_count
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
    async getUsers({commit, state}, page = 1, first = 100) {
      const response = await GraphQL.query({
        query:     gql`
          query Users($page: Int!, $first: Int!) {
            users(page: $page, first: $first) {
              data {
                id
                name
                email
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
     * @param data
     * @returns {Promise<void>}
     */
    async getLogs({commit, state}, data) {
      console.log(data);
      if (!data.page) {
        data.page = 1;
      }
      if (!data.first) {
        data.first = 100;
      }
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
          page:  data.page,
          first: data.first
        }
      });

      commit('SET_LOGS', response.data.logs.data);
    },

  }

});

export default store;
