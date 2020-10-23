<template>
  <div class="mb-5">

    <page-header :name="trans('main.servers.description')">
      <router-link class="d-none d-sm-inline-block btn btn-sm btn-primary" :to="{ name: 'servers.create' }">
        <i class="fa fa-plus-square"></i>
        {{ 'main.servers.create' | trans }}
      </router-link>
    </page-header>

    <div class="card border-0">
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
      columns: ['id', 'hostname', 'ipv4', 'ipv6', 'users_count'],
      options: {
        headings: {
          id:          'ID',
          hostname:    'Hostname',
          ipv4:        'IPv4',
          ipv6:        'IPv6',
          users_count: 'Users',
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
