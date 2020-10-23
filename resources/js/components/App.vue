<template>
  <div>
    <!--    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">-->
    <!--      <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Company name</a>-->
    <!--      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu"-->
    <!--              aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">-->
    <!--        <span class="navbar-toggler-icon"></span>-->
    <!--      </button>-->
    <!--      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
    <!--      <ul class="navbar-nav px-3">-->
    <!--        <li class="nav-item text-nowrap">-->
    <!--          <a class="nav-link" href="#">Sign out</a>-->
    <!--        </li>-->
    <!--      </ul>-->
    <!--    </nav>-->

    <div  v-if="isAuthorized">
      <toolbar style="z-index: 999" />

      <div class="container bg-white">
        <div class="row">

          <sidebar />

          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <router-view />
          </main>
        </div>
      </div>
    </div>
    <div v-else>
      <router-view />
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
  },

  mounted() {
    if (this.isAuthorized) {
      this.$store.dispatch("getGroups");
      this.$store.dispatch("getLogs");
      this.$store.dispatch("getServers");
      this.$store.dispatch("getStats");
      this.$store.dispatch("getUsers");
    }
  }
}
</script>
