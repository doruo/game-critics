<script setup lang="ts">
import NotifComponent from './NotifComponent.vue';
import { addNotif, notifList } from '@/util/notifStore';

</script>

<template>
  <div class="notif-container">
    <NotifComponent v-for="notif in notifList" :key="notif.id" :notif="notif" />
  </div>
</template>

<style scoped>
  .notif-container {
    position: fixed;
    right: 0;
    top: 0;
    width: 300px;
  }
</style>
