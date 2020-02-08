<template>
  <div class="mb-5">
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
