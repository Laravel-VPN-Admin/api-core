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
            <inertia-link :href="'/' + column + '/edit/' + item[column].id">
              {{ item[column].name ? item[column].name : item[column].hostname }}
            </inertia-link>
          </div>
          <div v-else-if="column === `id` && route !== undefined">
            <inertia-link :href="'/' + route + '/show/'+ item.id">
              {{ item.id }}
            </inertia-link>
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
  }
</script>