<template>
  <div>
    <div class="col-lg-12">
      <div class="mb-5">
        <page-header :name="name"/>
      </div>
    </div>
    <div class="col-lg-6">
      <form class="create-group">
        <div class="form-group">
          <input type="text" v-model="form.name" class="form-control form-control-user" placeholder="Name"/>
        </div>
        <div class="form-group">
          <input type="text" v-model="form.object" class="form-control form-control-user" placeholder="Object"/>
        </div>
        <button class="btn btn-primary btn-user btn-block w-50" @click="addGroup()" :disabled="!isSubmitEnabled()">
          <i class="fa fa-plus-circle mr-1"></i>Add Group
        </button>
      </form>
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
        name: "Add Group",
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
