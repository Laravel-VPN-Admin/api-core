<template>
  <div class="row">

    <div class="col-4 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total users</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ stats.users_count }}</div>
            </div>
            <div class="col-auto">
              <i class="fa fa-user fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-4 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total servers</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ stats.servers_count }}</div>
            </div>
            <div class="col-auto">
              <i class="fa fa-server fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-4 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total groups</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ stats.groups_count }}</div>
            </div>
            <div class="col-auto">
              <i class="fa fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import { mapState } from "vuex";

  export default {

    computed: {
      ...mapState([
        'stats',
      ]),
    },

    mounted() {
      this.$store.dispatch('getStats');
    },

  }
</script>
