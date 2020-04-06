<template>
  <div class="mb-5">
    <page-header :name="'main.titles.users' | trans" />

    <div class="card border-0 shadow">
      <vue-table
        route="users"
        :items="users"
        :columns="columns"
        :options="options"
      />
    </div>

  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import { mapState } from "vuex";
  import VueTable     from "../Layout/VueTable";

  export default {

    computed: {
      ...mapState([
        'groups',
        'servers',
        'users',
      ]),
    },

    data() {
      return {
        columns: ['id', 'name', 'email', 'updated_at', 'created_at'],
        options: {
          headings: {
            id:         'ID',
            name:       'Name',
            email:      'Email',
            created_at: 'Created at',
            updated_at: 'Updated at',
          },
        },
      };
    },

    components: {
      PageHeader,
      VueTable
    },

    mounted() {
      this.$store.dispatch('getUsers');
    }

  }
</script>
