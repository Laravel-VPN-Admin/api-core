<template>
  <app>
    <div class="mb-5">
      log message
    </div>
  </app>
</template>

<script>

  import App from '../App'

  export default {
    props: {
      id: Number
    },

    components: {
      App
    }
  }
</script>
