<template>
  <div>
    <div class="col-lg-12">
      <div class="mb-5">
        <page-header :name="name" />
      </div>
    </div>
    <div class="col-lg-6">
      <form class="create-server">
        <div class="form-group">
          <input type="text" v-model="form.hostname" class="form-control form-control-user" placeholder="Hostname" />
        </div>
        <div class="form-group"><input type="text" v-model="form.token" class="form-control form-control-user" placeholder="Token" /></div>
        <div class="form-group"><input type="text" v-model="form.ipv4" class="form-control form-control-user" placeholder="IPv4" /></div>
        <div class="form-group"><input type="text" v-model="form.ipv6" class="form-control form-control-user" placeholder="IPv6" /></div>
        <div class="form-group">
          <label for="selectGroup">Select Group</label>
          <select class="form-control" v-model="selected" id="selectGroup">
            <option v-for="group in groups" :key="group.id" :value="{ id: group.id, name: group.name }">{{ group.name }}</option>
          </select>
          <div>{{selected.name}}</div>
        </div>
        <button class="btn btn-primary btn-user btn-block w-50" @click="addServer()" :disabled="!isSubmitEnabled()">
          <i class="fa fa-plus-circle mr-1"></i>Add Server
        </button>
      </form>
    </div>
  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import { mapState } from "vuex";

  export default {
    computed:   {
      ...mapState(["groups"])
    },
    components: {
      PageHeader
    },
    data() {
      return {
        name:     "Add Server",
        form:     {hostname: null},
        selected: ''
      };
    },
    methods:    {
      isSubmitEnabled() {
        return this.form.hostname;
      },
      addServer: function () {
        this.$store.dispatch("createServer", {...this.selected, ...this.form});
      }
    },
    mounted() {
      this.$store.dispatch("getGroups");
    }
  };
</script>
