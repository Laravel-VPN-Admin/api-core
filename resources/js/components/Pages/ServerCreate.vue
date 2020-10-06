<template>
  <app>
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
          <div class="form-group">
            <voerro-tags-input
              v-model="selected"
              :existing-tags="tags"
              :only-existing-tags="true"
              typeahead-style="badges"
              :typeahead-hide-discard="true"
              :typeahead-always-show="true"
              :typeahead="true" />
          </div>
          <button class="btn btn-primary btn-user btn-block w-50" @click="createServer()" :disabled="!isSubmitEnabled()">
            <i class="fa fa-plus-circle mr-1"></i>{{ 'main.servers.create' | trans }}
          </button>
        </div>
      </div>
    </div>
  </app>
</template>

<script>
  import App      from "../App";
  import PageHeader      from "../Layout/PageHeader";
  import { mapState }    from "vuex";
  import VoerroTagsInput from '@voerro/vue-tagsinput';
  import _               from "lodash";

  export default {
    computed:   {
      ...mapState([
        "groups"
      ])
    },
    components: {
      App,
      PageHeader,
      VoerroTagsInput
    },
    data() {
      return {
        name:     this.trans('main.servers.create'),
        server:   {
          hostname: null,
          token:    null,
          ipv4:     null,
          ipv6:     null,
        },
        tags:     [],
        selected: []
      };
    },
    methods:    {
      transformToTags:   function (data) {
        return {key: data.id, value: data.name + " " + data.id};
      },
      transformToGroups: function (data) {
        return parseInt(data.key);
      },
      isSubmitEnabled:   function () {
        return this.server.hostname;
      },
      createServer:      function () {
        this.$store.dispatch("createServer", {groups: _.map(this.selected, this.transformToGroups), ...this.server});
      }
    },
    mounted() {
      this.$store.dispatch("getGroups").then(() => {
        this.tags = _.map(this.groups, this.transformToTags);
      })
    }
  };
</script>
