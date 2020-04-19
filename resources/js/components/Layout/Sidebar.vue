<template>
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="rotate-n-15">
        <img src="/images/favicon/favicon-32x32.png">
      </div>
      <div class="sidebar-brand-text mx-3">VPN Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <router-link tag="li" class="nav-item" :to="{name: 'dashboard'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>{{ 'main.dashboard.title' | trans }}</span>
      </a>
    </router-link>

    <hr class="sidebar-divider my-0">

    <router-link tag="li" class="nav-item" :to="{name: 'users'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-users"></i>
        <span>{{ 'main.users.title' | trans }}</span>
      </a>
    </router-link>

    <router-link tag="li" class="nav-item" :to="{name: 'servers'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-network-wired"></i>
        <span>{{ 'main.servers.title' | trans }}</span>
      </a>
    </router-link>

    <router-link tag="li" class="nav-item" :to="{name: 'groups'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-boxes"></i>
        <span>{{ 'main.groups.title' | trans }}</span>
      </a>
    </router-link>

    <hr class="sidebar-divider my-0">

    <router-link tag="li" class="nav-item" :to="{name: 'logs'}">
      <a class="nav-link">
        <i class="fas fa-fw fa-columns"></i>
        <span>{{ 'main.logs.title' | trans }}</span>
      </a>
    </router-link>

  </ul>
</template>
