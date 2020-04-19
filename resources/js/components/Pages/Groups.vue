<template>
  <div class="mb-5">

    <template>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ 'main.groups.description' | trans }}</h1>
        <router-link class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" :to="{ name: 'groups.create' }">
          <i class="fa fa-plus-square"></i>
          {{ 'main.groups.create' | trans }}
        </router-link>
      </div>
    </template>

    <div class="card border-0 shadow">
      <vue-table
        route="groups"
        :items="groups"
        :columns="columns"
        :options="options"
      />
    </div>
  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import { mapState } from 'vuex';
  import VueTable     from "../Layout/VueTable";

  export default {

    components: {
      PageHeader,
      VueTable
    },

    computed: {
      ...mapState([
        'groups',
        'servers',
        'users',
      ]),
    },

    data() {
      return {
        columns: ['id', 'name', 'users_count', 'servers_count'],
        options: {
          headings: {
            id:           'ID',
            name:         'Name',
            users_count:   'Users count',
            servers_count: 'Servers count',
          },
        },
      };
    },

    mounted() {
      this.$store.dispatch('getGroups');
    }

  }
</script>
