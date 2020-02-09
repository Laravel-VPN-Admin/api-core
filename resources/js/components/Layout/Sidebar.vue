<template>
  <ul class="navbar-nav bg-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <router-link tag="li" class="nav-item" :to="{name: 'dashboard'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        Dashboard
      </a>
    </router-link>

    <router-link tag="li" class="nav-item" :to="{name: 'servers'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        Servers
      </a>
    </router-link>

    <router-link tag="li" class="nav-item" :to="{name: 'groups'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        Groups
      </a>
    </router-link>

    <router-link tag="li" class="nav-item" :to="{name: 'users'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        Users
      </a>
    </router-link>

    <router-link tag="li" class="nav-item" :to="{name: 'logs'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        Logs
      </a>
    </router-link>

  </ul>
</template>
