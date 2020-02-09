<template>
  <div class="mb-5">
    <page-header :name="name" />
    <logs-table />
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
        name: "Logs from servers"
      }
    },

  }
</script>
