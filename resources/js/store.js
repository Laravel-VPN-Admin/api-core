import Vue    from "vue";
import Vuex   from "vuex";
import gql    from 'graphql-tag';
import apollo from './apollo';

import { router } from "./app";

Vue.use(Vuex);

const store = new Vuex.Store({

  state: {
    token:   null,
    users:   {},
    servers: {},
    groups:  {},
    logs:    {},
    stats:   {},
    server:  {}
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
    SET_SERVER(state, items) {
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
     * @returns {Promise<ExecutionResult<any> & {extensions?: Record<string, any>; context?: Record<string, any>}>}
     */
    async login({commit, state, dispatch}, data = {}) {
      return await apollo.mutate({
        mutation:  gql`
          mutation($input: UserLogin!) {
            login(input: $input) {
              token
              message
            }
          }
        `,
        variables: {
          input: {
            email:    data.email,
            password: data.password,
          }
        }
      })
      .then((response) => {
        if (typeof response.data.login.token != 'undefined') {
          localStorage.setItem('token', response.data.login.token);
          commit("SET_TOKEN", response.data.login.token);
          $cookies.set("token", response.data.login.token);
        }
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

    /**
     * Logout user by deleting token from session
     */
    logout({commit}) {
      console.log("User logout");
      commit("SET_TOKEN", null);
      localStorage.removeItem('token');
      $cookies.remove("token");
      router.push({name: "login"});
    },

    /**
     * Get list of all available groups
     *
     * @param {*} data
     * @returns {Promise<ApolloQueryResult<any>>}
     */
    async getGroups({commit, state, dispatch}, data = {}) {
      if (typeof data.page === 'undefined') {
        data.page = 1;
      }
      if (typeof data.first === 'undefined') {
        data.first = 100;
      }
      return await apollo.query({
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
          page:  data.page,
          first: data.first
        }
      })
      .then((response) => {
        if (typeof response.data != 'undefined') {
          commit('SET_GROUPS', response.data.groups.data);
        }
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

    /**
     * Get list of all available servers
     *
     * @param {*} data
     * @returns {Promise<ApolloQueryResult<any>>}
     */
    async getServers({commit, state, dispatch}, data = {}) {
      if (!data.page) {
        data.page = 1;
      }
      if (!data.first) {
        data.first = 100;
      }
      return await apollo.query({
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
          page:  data.page,
          first: data.first
        }
      })
      .then((response) => {
        if (typeof response.data.servers.data != 'undefined') {
          commit('SET_SERVERS', response.data.servers.data);
        }
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

    /**
     * Get list of all available users
     *
     * @param {*} data
     * @returns {Promise<ApolloQueryResult<any>>}
     */
    async getUsers({commit, state, dispatch}, data = {}) {
      if (!data.page) {
        data.page = 1;
      }
      if (!data.first) {
        data.first = 100;
      }
      return await apollo.query({
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
          page:  data.page,
          first: data.first
        }
      })
      .then((response) => {
        if (typeof response.data != 'undefined') {
          commit('SET_USERS', response.data.users.data);
        }
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

    /**
     * Get list of all server stats
     *
     * @returns {Promise<ApolloQueryResult<any>>}
     */
    async getStats({commit, dispatch}) {
      return await apollo.query({
        query: gql`
          query Stats {
            stats {
              users_count
              servers_count
              groups_count
            }
          }
        `
      })
      .then((response) => {
        if (typeof response.data.stats !== 'undefined') {
          commit('SET_STATS', response.data.stats);
        }
      })
      .catch((error) => {
        console.log(error);
        dispatch('logout');
      });
    },

    /**
     * Get list of all available logs
     *
     * @param {*} data
     * @returns {Promise<ApolloQueryResult<any>>}
     */
    async getLogs({commit, state, dispatch}, data = {}) {
      if (!data.page) {
        data.page = 1;
      }
      if (!data.first) {
        data.first = 100;
      }
      return await apollo.query({
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
      })
      .then((response) => {
        if (typeof response.data.logs.data != 'undefined') {
          commit('SET_LOGS', response.data.logs.data);
        }
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

    /**
     * Create new server
     *
     * @param {*} data
     * @returns {Promise<void>}
     */
    async createServer({commit, state, dispatch}, data = {}) {
      return await apollo.mutate({
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
      })
      .then((response) => {
        if (typeof response.data.server != 'undefined') {
          commit('SET_SERVER', response.data.server);
        }
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

  }

});

export default store;
