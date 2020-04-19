<template>
  <div class="mb-5">

    <template>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ 'main.users.description' | trans }}</h1>
        <router-link class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" :to="{ name: 'users.create' }">
          <i class="fa fa-plus-square"></i>
          {{ 'main.users.create' | trans }}
        </router-link>
      </div>
    </template>

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
