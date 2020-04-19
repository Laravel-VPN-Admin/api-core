<template>
  <div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <span class="card-title font-weight-bold" v-html="name" />
        </div>
        <div class="card-body">
          <div class="form-group">
            <input type="text" v-model="form.name" class="form-control form-control-user" placeholder="Name" />
          </div>
          <div class="form-group">
            <input type="text" v-model="form.object" class="form-control form-control-user" placeholder="Object" />
          </div>
          <button class="btn btn-primary btn-user btn-block w-50" @click="addGroup()" :disabled="!isSubmitEnabled()">
            <i class="fa fa-plus-circle mr-1"></i> {{ 'main.groups.create' | trans }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import PageHeader from "../Layout/PageHeader";

  export default {
    components: {
      PageHeader
    },
    data() {
      return {
        name: this.trans('main.groups.create'),
        form: {name: null}
      };
    },
    methods:    {
      isSubmitEnabled: function () {
        return this.form.name;
      },
      addGroup:        function () {
        this.$store.dispatch("createGroup", {...this.form});
      }
    }
  };
</script>
