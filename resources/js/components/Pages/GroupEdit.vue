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
          <div class="form-group">
            <input type="text" v-model="group.object" class="form-control form-control-user" placeholder="Object" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import PageHeader      from "../Layout/PageHeader";
  import _               from "lodash";

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
        name:       "Edit Group",
        show_block: false,
        group:     {
          name: null,
          object:    null
        }
      }
    },

    mounted() {
      if (this.groups.length > 0) {

        let group = this.$store.getters.getGroup(this.$route.params.id)
        if (group !== undefined) {
          this.group = group;
        }
        this.show_block = true;
      }
    },

    watch:   {
      group:   {
        handler: _.debounce(function (after) {
          let array    = _.pick(after, ['name', 'object']);
          this.$store.dispatch("updateGroup", {'id': this.$route.params.id, params: array});
        }, 100),
        deep:    true,
      }
    }
  };
</script>