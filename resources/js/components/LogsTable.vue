<template>
  <div class="card border-0">
    <table class="table table-bordered mb-0">
      <thead>
      <tr role="row">
        <th>Id</th>
        <th>Code</th>
        <th>Message</th>
        <th>User</th>
        <th>Server</th>
        <th>Created at</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="log in logs">
        <td>{{ log.id }}</td>
        <td>{{ log.code }}</td>
        <td>{{ log.message }}</td>
        <td>
          <router-link :to="{name: 'users.edit', params: {id: log.user.id}}">
            {{ log.user.name }}
          </router-link>
        </td>
        <td>
          <router-link :to="{name: 'servers.edit', params: {id: log.server.id}}">
            {{ log.server.hostname }}
          </router-link>
        </td>
        <td>{{ log.created_at }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  import { mapState } from "vuex";

  export default {

    props: {
      realtime: Boolean,
      page:     Number,
      first:    Number,
    },

    computed: {
      ...mapState([
        'groups',
        'servers',
        'users',
        'logs',
      ]),
    },

    data() {
      return {
        interval: null,
      }
    },

    mounted() {
      this.$store.dispatch('getLogs', {page: this.page, first: this.first});

      if (this.realtime) {
        this.interval = setInterval(function () {
          this.$store.dispatch('getLogs', {page: this.page, first: this.first});
        }.bind(this), 5000);
      }
    },

    beforeDestroy: function () {
      clearInterval(this.interval);
    },

  }
</script>
