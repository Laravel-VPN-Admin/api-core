<template>
  <app>
    <div class="mb-5">
      <page-header :name="'main.dashboard.title' | trans" />
      <stats />
      <div>list of connected users</div>
    </div>
  </app>
</template>

<script>
  import App from "../App";
  import PageHeader from "../Layout/PageHeader";
  import Stats      from "../Layout/Stats";

  export default {

    components: {
      App,
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
