<template>
    <div v-if="show_block">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <span class="card-title font-weight-bold" v-html="name"/>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" v-model="server.hostname" class="form-control form-control-user" placeholder="Hostname"/>
                    </div>
                    <div class="form-group">
                        <input type="text" v-model="server.token" class="form-control form-control-user" placeholder="Token"/>
                    </div>
                    <div class="form-group">
                        <input type="text" v-model="server.ipv4" class="form-control form-control-user" placeholder="IPv4"/>
                    </div>
                    <div class="form-group">
                        <input type="text" v-model="server.ipv6" class="form-control form-control-user" placeholder="IPv6"/>
                    </div>
                    <div class="form-group mb-0">
                        <voerro-tags-input
                                v-model="selected"
                                :existing-tags="tags"
                                :only-existing-tags="true"
                                typeahead-style="badges"
                                :typeahead-hide-discard="true"
                                :typeahead-always-show="true"
                                :typeahead="true"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PageHeader from "../Layout/PageHeader";
    import VoerroTagsInput from '@voerro/vue-tagsinput';
    import _ from "lodash";

    import {mapActions, mapState} from "vuex";

    export default {
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
            PageHeader,
            VoerroTagsInput
        },

        data() {
            return {
                name:       "Edit Server",
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
            if (this.servers.length > 0 && this.groups.length > 0) {
                if (this.groups !== undefined) {
                    this.tags = _.map(this.groups, this.transformToTags);
                }

                let server = this.$store.getters.getServer(this.$route.params.id)
                if (server !== undefined) {
                    this.server = server;
                    console.log(this.server.groups);
                    this.selected = _.map(this.server.groups, function (data) {
                        return {key: data.id, value: data.name + " " + data.id};
                    });
                }
                this.show_block = true;
            }
        },

        watch:   {
            server:   {
                handler: _.debounce(function (after) {
                    let array = _.pick(after, ['hostname', 'token', 'ipv4', 'ipv6']);
                    array.groups = _.map(this.selected, this.transformToGroups);
                    this.$store.dispatch("updateServer", {'id': this.$route.params.id, params: array});
                }, 100),
                deep:    true,
            },
            selected: {
                handler: _.debounce(function (after) {
                    let array = _.pick(this.server, ['hostname', 'token', 'ipv4', 'ipv6']);
                    array.groups = _.map(this.selected, this.transformToGroups);
                    this.$store.dispatch("updateServer", {'id': this.$route.params.id, params: array});
                }, 100),
                deep:    true,
            }
        },
        methods: {
            transformToTags:   function (data) {
                return {key: data.id, value: data.name + " " + data.id};
            },
            transformToGroups: function (data) {
                return parseInt(data.key);
            }
        }

    };
</script>

<style>
    /* The input */
    .tags-input {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .tags-input input {
        flex: 1;
        background: transparent;
        border: none;
    }

    .tags-input input:focus {
        outline: none;
    }

    .tags-input input[type="text"] {
        color: #495057;
    }

    .tags-input-wrapper-default {
        padding: .5em .25em;

        background: #fff;

        border: 1px solid transparent;
        border-radius: .25em;
        border-color: #dbdbdb;
    }

    .tags-input-wrapper-default.active {
        border: 1px solid #8bbafe;
        box-shadow: 0 0 0 0.2em rgba(13, 110, 253, 0.25);
        outline: 0 none;
    }

    /* The tag badges & the remove icon */
    .tags-input span {
        margin-right: 0.3em;
    }

    .tags-input-remove {
        cursor: pointer;
        position: absolute;
        display: inline-block;
        right: 0.3em;
        top: 0.3em;
        padding: 0.5em;
        overflow: hidden;
    }

    .tags-input-remove:focus {
        outline: none;
    }

    .tags-input-remove:before, .tags-input-remove:after {
        content: '';
        position: absolute;
        width: 75%;
        left: 0.15em;
        background: #5dc282;

        height: 2px;
        margin-top: -1px;
    }

    .tags-input-remove:before {
        transform: rotate(45deg);
    }

    .tags-input-remove:after {
        transform: rotate(-45deg);
    }

    /* Tag badge styles */
    .tags-input-badge {
        position: relative;
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25em;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tags-input-badge-pill {
        padding-right: 1.25em;
        padding-left: 0.6em;
        border-radius: 10em;
    }

    .tags-input-badge-selected-default {
        color: #212529;
        background-color: #f0f1f2;
    }

    /* Typeahead */
    .typeahead-hide-btn {
        color: #999 !important;
        font-style: italic;
    }

    /* Typeahead - badges */
    .typeahead-badges > span {
        cursor: pointer;
        margin-right: 0.3em;
    }

    /* Typeahead - dropdown */
    .typeahead-dropdown {
        list-style-type: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 100%;
        z-index: 1000;
    }

    .typeahead-dropdown li {
        padding: .25em 1em;
        cursor: pointer;
    }

    /* Typeahead elements style/theme */
    .tags-input-typeahead-item-default {
        color: #fff;
        background-color: #343a40;
    }

    .tags-input-typeahead-item-highlighted-default {
        color: #fff;
        background-color: #007bff;
    }
</style>