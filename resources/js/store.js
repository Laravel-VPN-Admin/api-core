import Vue        from "vue";
import Vuex       from "vuex";
import gql        from 'graphql-tag';
import { router } from './app';
import Cookies    from 'js-cookie';

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
      Cookies.set('token', items);
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
    ADD_GROUP(state, items) {
      state.groups.push(items);
    },
    ADD_SERVER(state, items) {
      state.servers.push(items);
    },
    ADD_USER(state, items) {
      state.users.push(items);
    },
    UPDATE_USER(state, changes) {
      // Find index of specific object using findIndex method.
      let index = state.users.findIndex((obj => obj.id === changes.id));

      // Update object's properties
      state.users[index] = changes;
    },
    UPDATE_GROUP(state, changes) {
      // Find index of specific object using findIndex method.
      let index = state.groups.findIndex((obj => obj.id === changes.id));

      // Update object's properties
      state.groups[index] = changes;
    },
    UPDATE_SERVER(state, changes) {
      // Find index of specific object using findIndex method.
      let index = state.servers.findIndex((obj => obj.id === changes.id));

      // Update object's properties
      state.servers[index] = changes;
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

    /**
     * Get server object by id
     *
     * @param {Number} id
     * @returns {*}
     */
    getServer: (state) => (id) => {
      return state.servers.find(server => server.id === id)
    },

    /**
     * Get user object by id
     *
     * @param {Number} id
     * @returns {*}
     */
    getUser: (state) => (id) => {
      return state.users.find(user => user.id === id)
    },

    /**
     * Get group object by id
     *
     * @param {Number} id
     * @returns {*}
     */
    getGroup: (state) => (id) => {
      return state.groups.find(group => group.id === id)
    }

  },

  actions: {

    /**
     * Logout user by deleting token from session
     */
    logout({commit}) {
      console.log("User logout");
      commit("SET_TOKEN", null);
      Cookies.remove("token");
      router.push({name: "login"});
    },

    /**
     * Get list of all available servers
     *
     * @param {*} data
     * @returns {Promise<void>}
     */
    async getServers({commit, state, dispatch}, data = {}) {
      if (!data.page) {
        data.page = 1;
      }
      if (!data.first) {
        data.first = 100;
      }
      return await window.apollo.query({
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
     * Extract user Object from list of groups
     *
     * @param id
     * @returns {*}
     */
    getUserById({commit, state}, id) {
      return state.users.find(user => user.id === parseInt(id));
    },

    /**
     * Get list of all available users
     *
     * @param {*} data
     * @returns {Promise<void>}
     */
    async getUsers({commit, state, dispatch}, data = {}) {
      if (!data.page) {
        data.page = 1;
      }
      if (!data.first) {
        data.first = 100;
      }
      return await window.apollo.query({
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
                  name
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
     * Submit settings of user
     *
     * @param {*} data
     * @returns {Promise<void>}
     */
    async updateUser({commit, state, dispatch}, data) {
      return await window.apollo.mutate({
        mutation:  gql`
          mutation($id: ID!, $input: UserUpdateInput!) {
            updateUser(id: $id, input: $input) {
              id
              name
              email
              object
              groups {
                id
                name
              }
              created_at
              updated_at
            }
          }
        `,
        variables: {
          id:    data.id,
          input: {
            "name":   data.params.name,
            "object": data.params.object
          }
        }
      })
      .then((response) => {
        commit('UPDATE_USER', response.data.updateUser);
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

    /**
     * Create new user
     *
     * @param {*} data
     * @returns {Promise<void>}
     */
    async createUser({commit, state, dispatch}, data = {}) {
      return await window.apollo.mutate({
        mutation:  gql`
          mutation($input: UserCreateInput!) {
            createUser(input: $input) {
              id
              name
              email
              object
              created_at
              updated_at
              groups {
                id
                name
              }
            }
          }
        `,
        variables: {
          input: {
            "name":   data.name,
            "email":  data.email,
            "object": data.object,
            "groups": {"sync": data.groups}
          }
        }
      })
      .then((response) => {
        commit('ADD_USER', response.data.createUser);
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

    /**
     * Get list of all servers stats
     *
     * @returns {Promise<void>}
     */
    async getStats({commit, dispatch}) {
      return await window.apollo.query({
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
        commit('SET_STATS', response.data.stats);
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
     * @returns {Promise<void>}
     */
    async getLogs({commit, state, dispatch}, data = {}) {
      if (!data.page) {
        data.page = 1;
      }
      if (!data.first) {
        data.first = 100;
      }
      return await window.apollo.query({
        query:     gql`
          query Logs($page: Int!, $first: Int!) {
            logs(page: $page, first: $first, orderBy: [{field: CREATED_AT, order: DESC}]) {
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
    async updateServer({commit, state, dispatch}, data) {
      return await window.apollo.mutate({
        mutation:  gql`
          mutation($id: ID!, $input: ServerUpdateInput!) {
            updateServer(id: $id, input: $input) {
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
          }
        `,
        variables: {
          id:    data.id,
          input: {
            "hostname": data.params.hostname,
            "ipv4":     data.params.ipv4,
            "ipv6":     data.params.ipv6,
            "groups":   {"sync": data.params.groups}
          }
        }
      })
      .then((response) => {
        commit('UPDATE_SERVER', response.data.updateServer);
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
      return await window.apollo.mutate({
        mutation:  gql`
          mutation($input: ServerCreateInput!) {
            createServer(input: $input) {
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
          }
        `,
        variables: {
          input: {
            "hostname": data.hostname,
            "ipv4":     data.ipv4,
            "ipv6":     data.ipv6,
            "groups":   {"sync": data.groups}
          }
        }
      })
      .then((response) => {
        commit('ADD_SERVER', response.data.createServer);
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
     * Get list of all available groups
     *
     * @param {*} data
     * @returns {Promise<void>}
     */
    async getGroups({commit, state, dispatch}, data = {}) {
      if (typeof data.page === 'undefined') {
        data.page = 1;
      }
      if (typeof data.first === 'undefined') {
        data.first = 100;
      }
      return await window.apollo.query({
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
     * Submit settings of room to group
     *
     * @param {*} data
     */
    async updateGroup({commit, state, dispatch}, data) {
      return await window.apollo.mutate({
        mutation:  gql`
          mutation($id: ID!, $input: GroupUpdateInput!) {
            updateGroup(id: $id, input: $input) {
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
          }
        `,
        variables: {
          id:    data.id,
          input: {
            "name":   data.params.name,
            "object": data.params.object
          }
        }
      })
      .then((response) => {
        commit('UPDATE_GROUP', response.data.updateGroup);
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

    /**
     * Create new group
     *
     * @param {*} data
     * @returns {Promise<void>}
     */
    async createGroup({commit, state, dispatch}, data = {}) {
      return await window.apollo.mutate({
        mutation:  gql`
          mutation($input: GroupCreateInput!) {
            createGroup(input: $input) {
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
          }
        `,
        variables: {
          input: {
            "name":   data.name,
            "object": data.object
          }
        }
      })
      .then((response) => {
        commit('ADD_GROUP', response.data.createGroup);
      })
      .catch((error) => {
        console.error(error);
        dispatch('logout');
      });
    },

  }

});

export default store;
