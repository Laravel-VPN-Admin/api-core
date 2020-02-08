<template>
  <div>
    <page-header :name="name" />
  </div>
</template>

<script>
  import PageHeader from "../Layout/PageHeader";

  export default {

    components: {
      PageHeader,
    },

    data() {
      return {
        name: "Dashboard"
      }
    },

  }
</script>
