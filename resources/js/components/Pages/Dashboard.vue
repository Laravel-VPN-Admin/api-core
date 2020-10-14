<template>
  <div class="mb-5">
    <page-header :name="'main.dashboard.title' | trans" />
    <stats />
    <div>list of connected users</div>
  </div>
</template>

<script>
import PageHeader from "../Layout/PageHeader";
import Stats      from "../Layout/Stats";

export default {

  components: {
    PageHeader,
    Stats
  },

}
</script>
