<template>
  <div>
    <page-header :name="name" />

    <div class="list-group">
      <div v-for="server in servers" class="list-group-item">
        {{ server.hostname }}
      </div>
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

    data() {
      return {
        name: "Servers"
      }
    },

    mounted() {
      this.$store.dispatch('getServers');
    }

  }
</script>
