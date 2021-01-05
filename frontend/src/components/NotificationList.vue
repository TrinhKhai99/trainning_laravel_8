<template>
  <div class="noteList">
    <NoteMess v-for="note in notifications" :key="note.id" :notification="note"/>
  </div>
</template>

<script>
import { mapState } from "vuex";
import NoteMess from "./Notification";
export default {
  components: {
    NoteMess
  },
  computed: mapState(["notifications"]),
};
</script>

<style>
.noteList {
  position: fixed;
  top: 0;
  right: 0;
  margin: 30px 15px 0 0;
  width: 320px;
  z-index: 99999;
}
</style>