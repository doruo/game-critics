<script setup lang="ts">
import { apiStore } from '@/util/apiStore';

function disconnect(): void {
  apiStore.logout();
}
</script>

<template>
  <h3> Confirm to log out</h3>
  <button @click="disconnect"> Confirm</button>
</template>

<style scoped>
</style>
