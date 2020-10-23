<template>
  <div class="mb-5">

    <page-header :name="trans('main.users.description')">
      <router-link class="d-none d-sm-inline-block btn btn-sm btn-primary" :to="{ name: 'users.create' }">
        <i class="fa fa-plus-square"></i>
        {{ 'main.users.create' | trans }}
      </router-link>
    </page-header>

    <div class="card border-0">
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
      columns: ['id', 'name', 'email'],
      options: {
        headings: {
          id:    'ID',
          name:  'Name',
          email: 'Email',
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
