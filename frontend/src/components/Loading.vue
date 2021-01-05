<template>
  <div class="kt9-loading" id="loader" v-show="showLoading">
    <div class="loader">
      <img src="./../../src/assets/Spinner-1s-200px.svg"/>
    </div>
  </div>
</template>

<script>
export default {
  name: "Loading",
  data() {
    return {
    };
  },
  computed: {
    showLoading() {
      return this.$store.state.showLoading;
    }
  },
};
</script>

<style scoped>
.kt9-loading {
  position: fixed;
  width: 100%;
  height: 100vh;
  top: 0;
  left: 0;
  background: #fff;
  z-index: 9999;
  opacity: 0.8;
}
.loader {
    width: 128px;
    height: 25px;
    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -12px;
    margin-left: -64px;
    z-index: 2;
    text-align: center;
    color: #fff;
}
</style>