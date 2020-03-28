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
    stats:   {},
    server: {}
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
    SET_STATS(state, items) {
      state.stats = items;
    },
    SET_SERVER(state, items){
      state.server = items;
    }
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
        throw error;
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
     * Get list of all server stats
     *
     * @returns {Promise<void>}
     */
    async getStats({commit, state}) {
      const response = await GraphQL.query({
        query: gql`
          query Stats {
            stats {
              users_count
              servers_count
              groups_count
            }
          }
        `
      });

      commit('SET_STATS', response.data.stats);
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
    /**
     *
     * @param commit
     * @param state
     * @param data
     * @returns {Promise<void>}
     */
    async createServer({commit, state}, data) {
      const response = await GraphQL.mutate({
        mutation:  gql`
       mutation($input: ServerCreateInput!) {
  createServer(input: $input) {
    id
    hostname
    ipv4
    ipv6
    token
    created_at
    updated_at
  }
}
        `,
        variables: {
          input: {
            "hostname": data.hostname,
            "ipv4":     data.ipv4,
            "ipv6":     data.ipv6,
            "token":    data.token,
            "groups":   {"connect": data.id}
          }
        }
      });

      commit('SET_SERVER', response.data.server);
    },


  }

});

export default store;
