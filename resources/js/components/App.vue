<template>
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
</template>

<script>
  import Sidebar from "./Layout/Sidebar";
  import Toolbar from "./Layout/Toolbar";

  export default {
    components: {
      Sidebar,
      Toolbar,
    }
  }
</script>
