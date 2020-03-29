<template>
  <div class="mb-5">
    <page-header :name="name" />
    <stats />
    <logs-table page="1" first="10" />
  </div>
</template>

<script>
  import PageHeader from "../Layout/PageHeader";
  import LogsTable  from "../Layout/LogsTable";
  import Stats      from "../Layout/Stats";

  export default {

    components: {
      LogsTable,
      PageHeader,
      Stats
    },

    data() {
      return {
        interval: null,
        name:     "Dashboard"
      }
    },

    mounted() {
      this.interval = setInterval(function () {
        // this.$store.dispatch('getLogs', {page: 1, first: 10});
        this.$store.dispatch('getStats');
      }.bind(this), 5000);
    },

    beforeDestroy: function () {
      clearInterval(this.interval);
    },

  }
</script>
