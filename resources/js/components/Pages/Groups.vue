<template>
  <div class="mb-5">
    <page-header :name="name" />

    <div class="card border-0 shadow">
      <table class="table table-bordered mb-0">
        <thead>
        <tr role="row">
          <th>Id</th>
          <th>Name</th>
          <th>Users count</th>
          <th>Servers count</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="group in groups" :key="group.id">
          <td>
            <router-link :to="{name: 'groups.edit', params: {id: group.id}}">
              {{ group.id }}
            </router-link>
          </td>
          <td>{{ group.name }}</td>
          <td>{{ group.users_count }}</td>
          <td>{{ group.servers_count }}</td>
        </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import { mapState } from 'vuex';

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
        name: "Groups"
      }
    },

    mounted() {
      this.$store.dispatch('getGroups');
    }

  }
</script>
