<template>
  <div class="wrapper">
    
    <div class="content-wrapper">
      <router-view></router-view>
    </div>
    <NotificationList/>

  </div>
</template>

<script>
import NotificationList from './../components/NotificationList';

export default {
  components: {
    NotificationList
  },
}
</script>

<style>

</style>