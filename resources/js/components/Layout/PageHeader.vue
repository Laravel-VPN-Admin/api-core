<template>
  <div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
      <h1 class="h2 mb-2">{{ name }}</h1>
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: String
  }
}
</script>
