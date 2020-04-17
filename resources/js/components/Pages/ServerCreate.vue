<template>
    <div>
        <div class="col-lg-12">
            <div class="mb-5">
                <page-header :name="name"/>
            </div>
        </div>
        <div class="col-lg-6">
            <form class="create-server">
                <div class="form-group">
                    <input type="text" v-model="form.hostname" class="form-control form-control-user" placeholder="Hostname"/>
                </div>
                <div class="form-group">
                    <input type="text" v-model="form.token" class="form-control form-control-user" placeholder="Token"/>
                </div>
                <div class="form-group">
                    <input type="text" v-model="form.ipv4" class="form-control form-control-user" placeholder="IPv4"/>
                </div>
                <div class="form-group">
                    <input type="text" v-model="form.ipv6" class="form-control form-control-user" placeholder="IPv6"/>
                </div>
                <div class="form-group">
                    <voerro-tags-input
                            v-model="selected"
                            :existing-tags="tags"
                            :only-existing-tags="true"
                            typeahead-style="badges"
                            :typeahead-hide-discard="true"
                            :typeahead-always-show="true"
                            :typeahead="true"/>
                </div>
                <button class="btn btn-primary btn-user btn-block w-50" @click="addServer()" :disabled="!isSubmitEnabled()">
                    <i class="fa fa-plus-circle mr-1"></i>Add Server
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    import PageHeader from "../Layout/PageHeader";
    import {mapState} from "vuex";
    import VoerroTagsInput from '@voerro/vue-tagsinput';
    import _ from "lodash";

    export default {
        computed:   {
            ...mapState(["groups"])
        },
        components: {
            PageHeader,
            VoerroTagsInput
        },
        data() {
            return {
                name:     "Add Server",
                form:     {hostname: null},
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
                return this.form.hostname;
            },
            addServer:         function () {
                this.$store.dispatch("createServer", {groups: _.map(this.selected, this.transformToGroups), ...this.form});
            }
        },
        mounted() {
            this.$store.dispatch("getGroups");
            if (this.groups !== undefined) {
                this.tags = _.map(this.groups, this.transformToTags);
            }
        }
    };
</script>
