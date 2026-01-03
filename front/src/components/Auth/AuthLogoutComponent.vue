<script setup lang="ts">
import { apiStore } from '@/util/apiStore';
import { addNotif } from '@/util/notifStore';

const emit = defineEmits<{
  logoutError: [message: string],
}>();

function disconnect(): void {
  apiStore.logout()
  .then((data) => {
    if (data.success) {
      addNotif({autoRemoved: true, type: 'success', message: "You have successfully been logged out"});
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "Logging out has failed : " + data.error});
      emit('logoutError', data.error as string);
    }
  });
}
</script>

<template>
  <h3> Confirm to log out</h3>
  <button @click="disconnect"> Confirm</button>
</template>

<style scoped>
</style>
