<template>
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">VPN Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

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
