<template>
  <div class="card border-0 shadow">
    <table class="table table-bordered mb-0">
      <thead>
      <tr role="row">
        <th>Id</th>
        <th>Code</th>
        <th>Message</th>
        <th>User</th>
        <th>Server</th>
        <th>Created at</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="log in logs">
        <td>{{ log.id }}</td>
        <td>{{ log.code }}</td>
        <td>{{ log.message }}</td>
        <td>
          <router-link :to="{name: 'users.edit', params: {id: log.user.id}}">
            {{ log.user.name }}
          </router-link>
        </td>
        <td>
          <router-link :to="{name: 'servers.edit', params: {id: log.server.id}}">
            {{ log.server.hostname }}
          </router-link>
        </td>
        <td>{{ log.created_at }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  import { mapState } from "vuex";

  export default {

    props: {
      page:  String,
      first: String,
    },

    data() {
      return {
        columns: ['id', 'code', 'message', 'user', 'server', 'created_at'],
        data:    this.getData(),
        options: {
          headings:   {
            id:         'ID',
            code:       'Code',
            message:    'Message',
            user:       'User',
            server:     'Server',
            created_at: 'Created at',
          },
          sortable:   ['name', 'message', 'user', 'server', 'created_at'],
          filterable: ['name', 'message', 'user', 'server', 'created_at']
        }
      };
    },

    computed: {
      ...mapState([
        'groups',
        'servers',
        'users',
        'logs',
      ]),
    },

    mounted() {
      this.$store.dispatch('getLogs', {page: this.page, first: this.first});
    },

    methods: {
      getData() {
        return this.logs;
      }
    }

  }
</script>
