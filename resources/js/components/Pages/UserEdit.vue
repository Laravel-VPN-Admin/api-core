<template>
  <div v-if="show_block">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <span class="card-title font-weight-bold" v-html="name" />
        </div>
        <div class="card-body">
          <div class="form-group">
            <input type="text" v-model="user.name" class="form-control form-control-user" placeholder="Username" />
          </div>
          <div class="form-group">
            <input type="text" v-model="user.email" class="form-control form-control-user" placeholder="Email" />
          </div>
          <div class="form-group">
            <input type="text" v-model="user.object" class="form-control form-control-user" placeholder="Object" />
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
</template>

<script>
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
        "users"
      ]),
      ...mapActions([
        'getUserById',
        'updateUser'
      ]),
    },

    components: {
      PageHeader,
      VoerroTagsInput
    },

    data() {
      return {
        name:       this.trans('main.users.edit'),
        tags:       [],
        selected:   [],
        show_block: false,
        user:       {
          name:   null,
          email:  null,
          object: null,
        }
      }
    },

    mounted() {
      if (this.groups.length <= 0) {
        this.$store.dispatch("getGroups");
      }

      // If servers array of store is empty, then refresh and get details about current server
      if (this.users.length <= 0) {
        this.$store.dispatch("getUsers").then(() => {
          this.getUserDefaults();
        });
      } else {
        this.getUserDefaults();
      }
    },

    watch: {
      user:     {
        handler: _.debounce(function (after) {
          let array    = _.pick(after, ['id', 'name', 'email', 'object']);
          array.groups = _.map(this.selected, this.transformToGroups);
          this.$store.dispatch("updateUser", {'id': this.$route.params.id, params: array});
        }, 100),
        deep:    true,
      },
      selected: {
        handler: _.debounce(function (after) {
          let array    = _.pick(this.user, ['id', 'name', 'email', 'object']);
          array.groups = _.map(this.selected, this.transformToGroups);
          this.$store.dispatch("updateUser", {'id': this.$route.params.id, params: array});
        }, 100),
        deep:    true,
      }
    },

    methods: {

      /**
       * Force get details about server from servers array of store
       */
      getUserDefaults() {
        this.tags       = _.map(this.groups, this.transformToTags);
        this.user       = this.$store.getters.getUser(this.$route.params.id)
        this.selected   = _.map(this.user.groups, function (data) {
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

  }
</script>
