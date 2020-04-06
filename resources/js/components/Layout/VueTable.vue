<template>
  <div>
    <table class="table table-bordered mb-0">
      <thead>
      <tr role="row">
        <th v-for="column in columns">
          {{ options.headings[column] }}
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in items">
        <td v-for="column in columns">
          <div v-if="item[column].id">
            <router-link :to="{name: column + 's.edit', params: {id: item[column].id}}">
              {{ item[column].name ? item[column].name : item[column].hostname }}
            </router-link>
          </div>
          <div v-else-if="column === `id` && route !== undefined">
            <router-link :to="{name: route + '.edit', params: {id: item.id}}">
              {{ item.id }}
            </router-link>
          </div>
          <div v-else>
            {{ item[column] }}
          </div>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>


<script>
  export default {
    props: {
      route:   String,
      items:   Array,
      columns: Array,
      options: Object,
    },

    data() {
      return {
        columns: ['id', 'value'],
        data:    this.items,
        options: {
          headings: {
            id:    'ID',
            value: 'Value',
          },
          // sortable:   ['name', 'message', 'user', 'server', 'created_at'],
          // filterable: ['name', 'message', 'user', 'server', 'created_at']
        }
      };
    },

  }
</script>