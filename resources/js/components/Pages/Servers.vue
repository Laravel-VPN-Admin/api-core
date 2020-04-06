<template>
  <div class="mb-5">

    <template>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ 'main.titles.servers' | trans }}</h1>
        <router-link class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" :to="{ name: 'servers.create' }">
          <i class="fa fa-plus-square"></i>
          {{ 'main.servers.add' | trans }}
        </router-link>
      </div>
    </template>

    <div class="card border-0 shadow">
      <vue-table
        route="servers"
        :items="servers"
        :columns="columns"
        :options="options"
      />
    </div>

  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import ServerCreate from "./ServerCreate";
  import VueTable     from "../Layout/VueTable";
  import { mapState } from "vuex";

  export default {
    computed: {
      ...mapState([
        "groups",
        "servers",
        "users"
      ])
    },

    data() {
      return {
        columns: ['id', 'hostname', 'ipv4', 'ipv6', 'users_count', 'updated_at', 'created_at'],
        options: {
          headings: {
            id:          'ID',
            hostname:    'Hostname',
            ipv4:        'IPv4',
            ipv6:        'IPv6',
            users_count: 'Users count',
            created_at:  'Created at',
            updated_at:  'Updated at',
          },
        },
      };
    },

    components: {
      PageHeader,
      VueTable,
      ServerCreate
    },

    mounted() {
      this.$store.dispatch("getServers");
    }
  };
</script>
