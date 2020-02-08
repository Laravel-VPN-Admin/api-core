<template>
  <div>
    <page-header :name="name" />

    <div class="list-group">
      <div v-for="user in users" class="list-group-item">
        {{ user.name }}
      </div>
    </div>

  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import { mapState } from "vuex";

  export default {

    computed: {
      ...mapState([
        'groups',
        'servers',
        'users',
      ]),
    },

    components: {
      PageHeader,
    },

    data() {
      return {
        name: "Users"
      }
    },

    mounted() {
      this.$store.dispatch('getUsers');
    }

  }
</script>
