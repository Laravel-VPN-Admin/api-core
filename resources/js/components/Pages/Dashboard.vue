<template>
  <div class="mb-5">
    <page-header :name="name" />
    <logs-table page="1" first="10" :realtime="true" />
  </div>
</template>

<script>
  import PageHeader from "../Layout/PageHeader";
  import LogsTable  from "../LogsTable";

  export default {

    components: {
      LogsTable,
      PageHeader,
    },

    data() {
      return {
        name: "Dashboard"
      }
    },

  }
</script>
