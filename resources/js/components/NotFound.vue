<template>
  <div class="text-md-center">
    <h1>404</h1>
    <h2 class="my-3 headline">Sorry, page not found</h2>
    <div>
      <button class="btn btn-primary" @click="goBack">Take me back!</button>
      <button class="btn btn-primary" @click="goHome">Go Home</button>
    </div>
  </div>
</template>

<script>
  export default {
    methods: {
      goBack() {
        this.$router.go(-1);
      },
      goHome() {
        this.$router.push({path: '/'})
      }
    }
  }
</script>
<style scoped>
  h1 {
    font-size: 150px;
    line-height: 150px;
    font-weight: 700;
    color: #252932;
    text-shadow: rgba(61, 61, 61, 0.3) 1px 1px, rgba(61, 61, 61, 0.2) 2px 2px, rgba(61, 61, 61, 0.3) 3px 3px;
  }
</style>
