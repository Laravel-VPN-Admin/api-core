<template>
  <div class="mb-5">
    <page-header :name="name" />

    <div class="card border-0">
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

  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import { mapState } from "vuex";

  export default {

    computed: {
      ...mapState([
        'groups',
        'servers',
        'users',
        'logs',
      ]),
    },

    components: {
      PageHeader,
    },

    data() {
      return {
        name: "Logs from servers"
      }
    },

    mounted() {
      this.$store.dispatch('getLogs');
    }

  }
</script>
