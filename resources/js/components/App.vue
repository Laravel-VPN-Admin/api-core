<template>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <sidebar />
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <!--        <toolbar />-->
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid pt-3">
          <page-header name="dashboard" />

          <paginator-groups />
          <mutator-group />
        </div>
        <!-- End of Main Content -->

      </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->
</template>

<script>

  import Sidebar    from "./Sidebar";
  import Toolbar    from "./Toolbar";
  import PageHeader from "./PageHeader";

  import MutatorGroup    from "./MutatorGroup";
  import PaginatorGroups from "./PaginatorGroups";

  export default {
    components: {
      Sidebar,
      Toolbar,
      PageHeader,
      MutatorGroup,
      PaginatorGroups
    }
  }
</script>
