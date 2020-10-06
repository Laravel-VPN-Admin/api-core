<template>
  <div>
    <div>
      <div id="wrapper">
        <sidebar />
        <div id="content-wrapper" class="d-flex flex-column">
          <div id="content">
            <toolbar />
            <div class="container-fluid pt-3">
              <slot></slot>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Sidebar        from "./Layout/Sidebar";
  import Toolbar        from "./Layout/Toolbar";
  import { mapGetters } from "vuex";

  export default {

    components: {
      Sidebar,
      Toolbar,
    },

    mounted() {
        this.$store.dispatch("getGroups");
        this.$store.dispatch("getLogs");
        this.$store.dispatch("getServers");
        this.$store.dispatch("getStats");
        this.$store.dispatch("getUsers");
    }
  }
</script>
