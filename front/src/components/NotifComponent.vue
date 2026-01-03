<script setup lang="ts">
import { removeNotif } from '@/util/notifStore.ts';
import type { Notif } from '../types.ts';

const props = defineProps<{
  notif: Notif,
}>();

</script>

<template>
  <div class="notification" :class="(notif.type)">
    <button @click="removeNotif(notif)">Close</button>
    <h2> {{ notif.type }}</h2>
    <p> {{ notif.message }}</p>
    <div class="progress-bar"></div>
  </div>
</template>

<style scoped>
  .notification {
    border: 2px solid black;
    width: 100%;
  }

    .notification.success {
      border-color: green;
    }

    .notification.warning {
      border-color: orange;
    }
    
    .notification.error {
      border-color: red;
    }

    .notification .progress-bar {
      height: 5px;
      background-color: blue;
      /* 5s est le temps défini dans notifStore.ts */
      animation: progress-bar-animation 5s linear;
    }
    @keyframes progress-bar-animation{
        0%{
          width: 0%;
        }
        100%{
          width: 100%;
        }
    };
</style>
