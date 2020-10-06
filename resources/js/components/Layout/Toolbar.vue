<template>
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

      <inertia-link tag="li" class="nav-item dropdown no-arrow mx-1" href="settings">
        <a class="nav-link">
          <i class="fas fa-fw fa-cog"></i>
        </a>
      </inertia-link>

      <div class="topbar-divider d-none d-sm-block"></div>

      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">Super King</span>
          <img class="img-profile rounded-circle" src="https://source.unsplash.com/60x60">
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <button class="dropdown-item" @click="logout()">
            Logout
          </button>
        </div>
      </li>

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
