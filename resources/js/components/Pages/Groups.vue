<template>
  <div>
    <page-header :name="name" />

    <div class="list-group">
      <div v-for="group in groups" class="list-group-item">
        {{ group.name }}
      </div>
    </div>

  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import { mapState } from 'vuex';

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
        name: "Groups"
      }
    },

    mounted() {
      this.$store.dispatch('getGroups');
    }

  }
</script>
