<template>
  <div class="mb-5">
    <page-header :name="'main.titles.groups' | trans" />
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
