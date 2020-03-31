<template>
  <div class="mb-5">

    <template>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ 'main.titles.servers' | trans }}</h1>
        <router-link class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" :to="{ name: 'servers.create' }">
          <i class="fa fa-plus-square"></i>
          Add Server
        </router-link>
      </div>
    </template>

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
        <tr v-for="server in servers" :key="server.id">
          <td>
            <router-link :to="{ name: 'servers.edit', params: { id: server.id } }">
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
  import ServerCreate from "./ServerCreate";
  import { mapState } from "vuex";

  export default {
    computed: {
      ...mapState([
        "groups",
        "servers",
        "users"
      ])
    },

    components: {
      PageHeader,
      ServerCreate
    },

    mounted() {
      this.$store.dispatch("getServers");
    }
  };
</script>
