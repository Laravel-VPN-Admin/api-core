<template>
  <div>
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
            <input type="text" v-model="user.password" class="form-control form-control-user" placeholder="Password" />
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
          <button class="btn btn-primary btn-user btn-block w-50 mt-3" @click="createUser()" :disabled="!isSubmitEnabled()">
            <i class="fa fa-plus-circle mr-1"></i>{{ 'main.users.create' | trans }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import PageHeader       from "../Layout/PageHeader";
  import { mapState }     from "vuex";
  import VoerroTagsInput  from '@voerro/vue-tagsinput';
  import _                from "lodash";
  import generatePassword from "omgopass";

  export default {

    computed: {
      ...mapState([
        "groups"
      ])
    },

    components: {
      PageHeader,
      VoerroTagsInput
    },

    data() {
      return {
        name:     this.trans('main.users.create'),
        user:     {
          name:     null,
          email:    null,
          object:   null,
          password: generatePassword(),
        },
        tags:     [],
        selected: []
      };
    },

    methods: {

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
      },

      /**
       * Check if required fields is not empty
       *
       * @returns {boolean}
       */
      isSubmitEnabled: function () {
        return this.user.name && this.user.email && this.user.password;
      },

      /**
       * Create new user and add to users array
       */
      createUser: function () {
        this.$store.dispatch("createUser", {groups: _.map(this.selected, this.transformToGroups), ...this.user});
      }

    },

    mounted() {
      this.$store.dispatch("getGroups").then(() => {
        this.tags = _.map(this.groups, this.transformToTags);
      });
    }

  };
</script>
