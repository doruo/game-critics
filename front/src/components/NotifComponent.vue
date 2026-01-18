<script setup lang="ts">
import { removeNotif } from '@/util/notifStore.ts';
import type { Notif } from '../types.ts';
import NavButton from './NavButton.vue';

const props = defineProps<{
  notif: Notif,
}>();

</script>

<template>
  <div class="notification" :class="(notif.type)">
    <NavButton @click="removeNotif(notif)">Close</NavButton>
    <h2> {{ notif.type }}</h2>
    <p> {{ notif.message }}</p>
    <div class="progress-bar"></div>
  </div>
</template>

<style scoped>
  .notification {
    border: 10px solid black;
    border-radius: 15px;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(4px);
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
