<template>
  <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">

    <div class="container mt-3 mb-3">

      <router-link class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" :to="{name: 'dashboard'}">
<!--        <img class="mr-1" src="/images/logo/vpn-logo-v2.png" alt="VPN Admin" width="48" height="48">-->
        VPN Admin
      </router-link>

      <button class="navbar-toggler position-absolute d-md-none collapsed"
              type="button" data-toggle="collapse" data-target="#sidebarMenu"
              aria-controls="sidebarMenu" aria-expanded="false"
              aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <ul class="navbar-nav ml-auto">

        <!--      <router-link tag="li" class="nav-item dropdown no-arrow mx-1" :to="{name: 'settings'}">-->
        <!--        <a class="nav-link">-->
        <!--          <i class="fas fa-fw fa-cog"></i>-->
        <!--        </a>-->
        <!--      </router-link>-->

        <b-nav-item-dropdown right class="navbar-nav px-3">
          <template v-slot:button-content class="nav-item text-nowrap">
            Super King
          </template>
          <b-dropdown-item @click="logout()">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>

      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$store.dispatch("logout");
    }
  }
};
</script>
