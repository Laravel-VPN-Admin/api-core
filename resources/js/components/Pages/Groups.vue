<template>
  <div>
    <page-header :name="name" />
    <h1>This is the {{ name }}</h1>
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
        name: "Groups"
      }
    },

  }
</script>
