<template>
  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky">
      <ul class="nav flex-column">

        <router-link tag="li" class="nav-item" :to="{name: 'dashboard'}">
          <a class="nav-link">
            <span>{{ 'main.dashboard.title' | trans }}</span>
          </a>
        </router-link>

        <router-link tag="li" class="nav-item" :to="{name: 'users'}">
          <a class="nav-link">
            <span>{{ 'main.users.title' | trans }}</span>
          </a>
        </router-link>

        <router-link tag="li" class="nav-item" :to="{name: 'servers'}">
          <a class="nav-link">
            <span>{{ 'main.servers.title' | trans }}</span>
          </a>
        </router-link>

        <router-link tag="li" class="nav-item" :to="{name: 'groups'}">
          <a class="nav-link">
            <span>{{ 'main.groups.title' | trans }}</span>
          </a>
        </router-link>

        <router-link tag="li" class="nav-item" :to="{name: 'logs'}">
          <a class="nav-link">
            <span>{{ 'main.logs.title' | trans }}</span>
          </a>
        </router-link>

      </ul>
    </div>
  </nav>
</template>
