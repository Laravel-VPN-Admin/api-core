<template>
  <div>
    <div v-if="isAuthorized">
      <div id="wrapper">
        <sidebar />
        <div id="content-wrapper" class="d-flex flex-column">
          <div id="content">
            <div class="container-fluid pt-3">
              <router-view></router-view>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import Sidebar        from "./Layout/Sidebar";
  import Toolbar        from "./Layout/Toolbar";
  import { mapGetters } from "vuex";

  export default {

    computed: {
      ...mapGetters([
        'isAuthorized',
      ]),
    },

    components: {
      Sidebar,
      Toolbar,
    }
  }
</script>
