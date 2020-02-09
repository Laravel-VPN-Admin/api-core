<template>
  <div class="mb-5">
    <page-header :name="name" />

    <div class="card border-0 shadow">
      <table class="table table-bordered mb-0">
        <thead>
        <tr role="row">
          <th>Id</th>
          <th>Hostname</th>
          <th>IPv4</th>
          <th>IPv6</th>
          <th>Users count</th>
          <th>Updated at</th>
          <th>Created at</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="server in servers">
          <td>
            <router-link :to="{name: 'servers.edit', params: {id: server.id}}">
              {{ server.id }}
            </router-link>
          </td>
          <td>{{ server.hostname }}</td>
          <td>{{ server.ipv4 }}</td>
          <td>{{ server.ipv6 }}</td>
          <td>{{ server.users_count }}</td>
          <td>{{ server.updated_at }}</td>
          <td>{{ server.created_at }}</td>
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
      ]),
    },

    components: {
      PageHeader,
    },

    data() {
      return {
        name: "Servers"
      }
    },

    mounted() {
      this.$store.dispatch('getServers');
    }

  }
</script>
