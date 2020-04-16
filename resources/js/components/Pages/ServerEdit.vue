<template>
  <div v-if="show_block">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <span class="card-title font-weight-bold" v-html="name" />
        </div>
        <div class="card-body">
          <div class="form-group">
            <input type="text" v-model="server.hostname" class="form-control form-control-user" placeholder="Hostname" />
          </div>
          <div class="form-group">
            <input type="text" v-model="server.token" class="form-control form-control-user" placeholder="Token" />
          </div>
          <div class="form-group">
            <input type="text" v-model="server.ipv4" class="form-control form-control-user" placeholder="IPv4" />
          </div>
          <div class="form-group">
            <input type="text" v-model="server.ipv6" class="form-control form-control-user" placeholder="IPv6" />
          </div>
          <div class="form-group mb-0">
            <select class="form-control" v-model="selected" id="selectGroup">
              <option value="0" selected>
                Select Group
              </option>
              <option v-for="group in groups" :key="group.id" :value="{ id: group.id, name: group.name }">
                {{ group.name }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import PageHeader from "../Layout/PageHeader";
  import _          from "lodash";

  import { mapActions, mapState } from "vuex";

  export default {
    computed: {
      ...mapState([
        "groups",
        "servers"
      ]),
      ...mapActions([
        'getServerById',
        'updateServer'
      ]),
    },

    components: {
      PageHeader
    },

    data() {
      return {
        name:       "Edit Server",
        selected:   0,
        show_block: false,
        server:     {
          hostname: null,
          token:    null,
          ipv4:     null,
          ipv6:     null,
        }
      }
    },

    mounted() {
      if (this.servers.length > 0) {
        let server = this.$store.getters.getServer(this.$route.params.id)
        if (server !== undefined) {
          this.server = server;
        }
        this.show_block = true;
      }
    },

    watch: {
      server: {
        handler: _.debounce(function (after) {
          const array = _.pick(after, ['hostname', 'token', 'ipv4', 'ipv6']);
          this.$store.dispatch("updateServer", {'id': this.$route.params.id, params: array});
        }, 100),
        deep:    true,
      },
    }

  };
</script>
