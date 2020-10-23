<template>
  <div class="mb-5">

    <page-header :name="trans('main.groups.description')">
      <router-link class="d-none d-sm-inline-block btn btn-sm btn-primary" :to="{ name: 'groups.create' }">
        <i class="fa fa-plus-square"></i>
        {{ 'main.groups.create' | trans }}
      </router-link>
    </page-header>

    <div class="card border-0">
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
            users_count:   'Users',
            servers_count: 'Servers',
          },
        },
      };
    },

    mounted() {
      this.$store.dispatch('getGroups');
    }

  }
</script>
