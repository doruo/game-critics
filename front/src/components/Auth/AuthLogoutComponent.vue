<script setup lang="ts">
import { apiStore } from '@/util/apiStore';

const emit = defineEmits<{
  logoutError: [message: string],
}>();

function disconnect(): void {
  apiStore.logout()
  .then((data) => {
    if (data.error)
      emit('logoutError', data.error);
  });
}
</script>

<template>
  <h3> Confirm to log out</h3>
  <button @click="disconnect"> Confirm</button>
</template>

<style scoped>
</style>
