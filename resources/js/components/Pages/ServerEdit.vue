<template>
  <app>
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
              <voerro-tags-input
                v-model="selected"
                :existing-tags="tags"
                :only-existing-tags="true"
                typeahead-style="badges"
                :typeahead-hide-discard="true"
                :typeahead-always-show="true"
                :typeahead="true" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </app>
</template>

<script>
  import App      from "../App";
  import PageHeader      from "../Layout/PageHeader";
  import VoerroTagsInput from '@voerro/vue-tagsinput';
  import _               from "lodash";

  import { mapActions, mapState } from "vuex";

  export default {
    props: {
      id: Number
    },

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
      App,
      PageHeader,
      VoerroTagsInput
    },

    data() {
      return {
        name:       this.trans('main.servers.edit'),
        tags:       [],
        selected:   [],
        show_block: false,
        server:     {
          hostname: null,
          token:    null,
          ipv4:     null,
          ipv6:     null
        }
      }
    },

    mounted() {
      // If servers array of store is empty, then refresh and get details about current server
      if (this.servers.length <= 0) {
        this.$store.dispatch("getServers").then(() => {
          this.getServerDefaults();
        });
      } else {
        this.getServerDefaults();
      }
    },

    watch: {
      server:   {
        handler: _.debounce(function (after) {
          let array    = _.pick(after, ['id', 'hostname', 'token', 'ipv4', 'ipv6']);
          array.groups = _.map(this.selected, this.transformToGroups);
          this.$store.dispatch("updateServer", {'id': this.id, params: array});
        }, 100),
        deep:    true,
      },
      selected: {
        handler: _.debounce(function (after) {
          let array    = _.pick(this.server, ['id', 'hostname', 'token', 'ipv4', 'ipv6']);
          array.groups = _.map(this.selected, this.transformToGroups);
          this.$store.dispatch("updateServer", {'id': this.id, params: array});
        }, 100),
        deep:    true,
      }
    },

    methods: {

      /**
       * Force get details about server from servers array of store
       */
      getServerDefaults() {
        this.tags       = _.map(this.groups, this.transformToTags);
        this.server     = this.$store.getters.getServer(this.id)
        this.selected   = _.map(this.server.groups, function (data) {
          return {key: data.id, value: data.name + " " + data.id};
        });
        this.show_block = true;
      },

      /**
       * Convert groups to tags
       *
       * @param data
       * @returns {{value: string, key: *}}
       */
      transformToTags: function (data) {
        return {key: data.id, value: data.name + " " + data.id};
      },

      /**
       * Transform tags to groups
       *
       * @param data
       * @returns {number}
       */
      transformToGroups: function (data) {
        return parseInt(data.key);
      }
    }

  };
</script>
