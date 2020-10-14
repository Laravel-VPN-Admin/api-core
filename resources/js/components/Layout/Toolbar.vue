<template>
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

      <router-link tag="li" class="nav-item dropdown no-arrow mx-1" :to="{name: 'settings'}">
        <a class="nav-link">
          <i class="fas fa-fw fa-cog"></i>
        </a>
      </router-link>

      <b-nav-item-dropdown right>
        <!-- Using 'button-content' slot -->
        <template v-slot:button-content>
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">Super King</span>
          <img class="img-profile rounded-circle" src="https://source.unsplash.com/60x60" alt="Profile Image" />
        </template>
        <b-dropdown-item @click="logout()">Sign Out</b-dropdown-item>
      </b-nav-item-dropdown>

    </ul>

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
