<template>
  <div class="mb-5">
    <page-header :name="'main.titles.logs' | trans" />
    <logs-table />
  </div>
</template>

<script>
  import PageHeader from "../Layout/PageHeader";
  import LogsTable  from "../Layout/LogsTable";

  export default {

    components: {
      LogsTable,
      PageHeader,
    },

  }
</script>
