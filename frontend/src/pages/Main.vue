<template>
  <div class="wrapper">

    <MenuSlideBar/>
    <div class="content-wrapper">
      <router-view></router-view>
    </div>
    <NotificationList/>
    <Loading/>

  </div>
</template>

<script>
import Loading from './../components/Loading';
import MenuSlideBar from './../components/MenuSlideBar';
import NotificationList from './../components/NotificationList';

export default {
  components: {
    NotificationList,
    MenuSlideBar,
    Loading,
  },
}
</script>

<style>

</style>