<template>
  <div v-if="show_block">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <span class="card-title font-weight-bold" v-html="name" />
        </div>
        <div class="card-body">
          <div class="form-group">
            <input type="text" v-model="group.name" class="form-control form-control-user" placeholder="Name" />
          </div>
          <div class="form-group mb-0">
            <input type="text" v-model="group.object" class="form-control form-control-user" placeholder="Object" />
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
        "groups"
      ]),
      ...mapActions([
        'updateGroup'
      ]),
    },

    components: {
      PageHeader
    },

    data() {
      return {
        name:       this.trans('main.groups.edit'),
        show_block: false,
        group:      {
          name:   null,
          object: null
        }
      }
    },

    methods: {

      /**
       * Force get details about group from groups array of store
       */
      getGroupDefaults() {
        this.group      = this.$store.getters.getGroup(this.$route.params.id);
        this.show_block = true;
      },

    },

    mounted() {
      // If servers array of store is empty, then refresh and get details about current server
      if (this.groups.length <= 0) {
        this.$store.dispatch("getGroups").then(() => {
          this.getGroupDefaults();
        });
      } else {
        this.getGroupDefaults();
      }
    },

    watch: {
      group: {
        handler: _.debounce(function (after) {
          let array = _.pick(after, ['id', 'name', 'object']);
          this.$store.dispatch("updateGroup", {'id': this.$route.params.id, params: array});
        }, 100),
        deep:    true,
      }
    }
  };
</script>