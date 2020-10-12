<template>
  <div class="mb-5">
    <page-header :name="'main.logs.description' | trans" />
    <div class="card border-0 shadow">
      <vue-table
        route="logs"
        :items="logs"
        :columns="columns"
        :options="options"
      />
    </div>
  </div>
</template>

<script>
  import PageHeader   from "../Layout/PageHeader";
  import VueTable     from "../Layout/VueTable";
  import { mapState } from "vuex";
  import gql from 'graphql-tag';
  export default {

    components: {
      PageHeader,
      VueTable
    },

    data() {
      return {
        columns: ['id', 'code', 'message', 'user', 'server', 'created_at'],
        options: {
          headings: {
            id:         'ID',
            code:       'Code',
            message:    'Message',
            user:       'User',
            server:     'Server',
            created_at: 'Created at',
          },
        },
      };
    },

    computed: {
      ...mapState([
        'logs',
      ]),
    },

    mounted() {
      this.$store.dispatch('getLogs', {page: this.page, first: this.first});
    },

    apollo: {
      $subscribe: {
        subscribed: {
          query: gql`
          subscription LogCreated {
            logCreated {
                id
                code
                created_at
                updated_at
                message
                server {
                    id
                    hostname
                }
                user {
                    id
                    name
                }
            }
          }
        `,
          result({ data }) {
            console.log(data.logCreated);
            //this.$store.commit('ADD_LOG', data.logCreated);
            //console.log(this.logs);
          },
        },
      },
    },

  }
</script>
