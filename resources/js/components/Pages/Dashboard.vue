<template>
  <div class="mb-5">
    <page-header :name="'main.titles.dashboard' | trans" />
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
      }
    },

    mounted() {
      this.interval = setInterval(function () {
        this.$store.dispatch('getLogs', {page: 1, first: 10});
      }.bind(this), 5000);
    },

    beforeDestroy: function () {
      clearInterval(this.interval);
    },

  }
</script>
