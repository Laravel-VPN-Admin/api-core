<template>
  <div>
    <page-header :name="name"/>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-bordered">
            <thead>
            <tr role="row">
              <th>Id</th>
              <th>Code</th>
              <th>Message</th>
              <th>User</th>
              <th>Server</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="log in logs">
              <td>{{ log.id }}</td>
              <td>{{ log.code }}</td>
              <td>{{ log.message }}</td>
              <td>{{ log.user.name }}</td>
              <td>{{ log.server.hostname }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import PageHeader from "../Layout/PageHeader";
  import {mapState} from "vuex";

  export default {

    computed: {
      ...mapState([
        'groups',
        'servers',
        'users',
        'logs',
      ]),
    },

    components: {
      PageHeader,
    },

    data() {
      return {
        name: "Logs"
      }
    },

    mounted() {
      this.$store.dispatch('getLogs');
    }

  }
</script>
