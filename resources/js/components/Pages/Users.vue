<template>
  <div class="mb-5">
    <page-header :name="'main.titles.users' | trans" />

    <div class="card border-0 shadow">
      <table class="table table-bordered mb-0">
        <thead>
        <tr role="row">
          <th>Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Updated at</th>
          <th>Created at</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users">
          <td>
            <router-link :to="{name: 'users.edit', params: {id: user.id}}">
              {{ user.id }}
            </router-link>
          </td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.updated_at }}</td>
          <td>{{ user.created_at }}</td>
        </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import { mapState } from "vuex";

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

    mounted() {
      this.$store.dispatch('getUsers');
    }

  }
</script>
