import Vue    from "vue";
import Vuex   from "vuex";
import gql    from 'graphql-tag';
import apollo from './apollo';

import { router } from "./app";

Vue.use(Vuex);

const store = new Vuex.Store({

  state: {
    token:   null,
    users:   [],
    servers: [],
    groups:  [],
    logs:    [],
    stats:   [],
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
  },

  getters: {
    /**
     * Check if user has token
     *
     * @returns {boolean}
     */
    isAuthorized: state => {
      return !!state.token;
    },

    getServer: (state) => (id) => {
      return state.servers.find(server => server.id === id)
    },

    getGroup: (state) => (id) => {
      return state.groups.find(group => group.id === id)
    }

  },

  actions: {

    /**
     * Submit login request to api server
     *
     * @param {*} data
     * @returns {Promise<T>}
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
     * @returns {Promise<T>}
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
     * @returns {Promise<T>}
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
                token
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
     * @returns {Promise<T>}
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
     * Get list of all servers stats
     *
     * @returns {Promise<T>}
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
     * @returns {Promise<T>}
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
     * Extract server Object from list of servers
     *
     * @param id
     * @returns {*}
     */
    getServerById({commit, state}, id) {
      return state.servers.find(server => server.id === parseInt(id));
    },

    /**
     * Submit settings of room to server
     *
     * @param {*} data
     */
    async updateServer({commit, state}, data) {
      return await apollo.mutate({
        mutation:  gql`
          mutation($id: ID!, $input: ServerUpdateInput!) {
            updateServer(id: $id, input: $input) {
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
          id:    data.id,
          input: {
            "hostname": data.params.hostname,
            "ipv4":     data.params.ipv4,
            "ipv6":     data.params.ipv6,
            "token":    data.params.token,
            "groups":   {"sync": data.params.groups}
          }
        }
      })
      .then((response) => {
        console.log(response);
        if (typeof response.data.server != 'undefined') {
          commit('SET_SERVER', response.data.server);
        }
      });
      // .catch((error) => {
      //   console.error(error);
      //   dispatch('logout');
      // });
    },

    /**
     * Create new server
     *
     * @param {*} data
     * @returns {Promise<T>}
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
            "groups":   {"sync": data.groups}
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

    /**
     * Extract group Object from list of groups
     *
     * @param id
     * @returns {*}
     */
    getGroupById({commit, state}, id) {
      return state.groups.find(group => group.id === parseInt(id));
    },

    /**
     * Submit settings of room to group
     *
     * @param {*} data
     */
    async updateGroup({commit, state}, data) {
      return await apollo.mutate({
        mutation:  gql`
          mutation($id: ID!, $input: GroupUpdateInput!) {
            updateGroup(id: $id, input: $input) {
              id
              name
              object
              created_at
              updated_at
            }
          }
        `,
        variables: {
          id:    data.id,
          input: {
            "name":       data.params.name,
            "object":     data.params.object
          }
        }
      })
      .then((response) => {
        console.log(response);
        if (typeof response.data.group != 'undefined') {
          commit('SET_GROUP', response.data.group);
        }
      });
      // .catch((error) => {
      //   console.error(error);
      //   dispatch('logout');
      // });
    },

    /**
     * Create new group
     *
     * @param {*} data
     * @returns {Promise<T>}
     */
    async createGroup({commit, state, dispatch}, data = {}) {
      return await apollo.mutate({
        mutation:  gql`
          mutation($input: GroupCreateInput!) {
            createGroup(input: $input) {
              id
              name
              object
              created_at
              updated_at
            }
          }
        `,
        variables: {
          input: {
            "name":     data.name,
            "object":   data.object
          }
        }
      })
      .then((response) => {
        if (typeof response.data.group != 'undefined') {
          commit('SET_GROUP', response.data.group);
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
