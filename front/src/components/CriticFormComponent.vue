<script setup lang="ts">
import { ref } from 'vue';
import type { Game } from '../types.ts';
import { apiStore, loggedInUser } from '@/util/apiStore.ts';
import { addNotif } from '@/util/notifStore.ts';

const emit = defineEmits<{
  œ: [],
}>();

const props = defineProps<{
  game: Game,
}>();

const newCritic = ref({
  author: loggedInUser.value,
  game: props.game,
  generalMessage: '',
  visualMessage: '',
  soundtrackMessage: '',
  scenarioMessage: '',
  note: 0.0,
});

function uploadCritic() : void {
  apiStore.createRessource('critics', newCritic.value)
  .then(res => {
    if (res.success) {
      addNotif({autoRemoved: true, type: 'success', message: "Your Critic has been uploaded"});
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "The Critic could not be uploaded : " + res.error});
    }
  });
}
</script>

<template>
  <form @submit.prevent="uploadCritic" class="critic-form">
    <p><b> General Critic :</b></p>
    <textarea v-model="newCritic.generalMessage" ></textarea>

    <p><b> Visuals Critic :</b></p>
    <textarea v-model="newCritic.visualMessage" ></textarea>

    <p><b> Soundtrack's Critic :</b></p>
    <textarea else v-model="newCritic.soundtrackMessage" ></textarea>

    <p><b> Scenario's Critic :</b></p>
    <textarea else v-model="newCritic.scenarioMessage" ></textarea>

    <p> Your Note : <input v-model="newCritic.note" type="number"> Stars</p>

    <button @click="$emit('hideForm')"> Cancel</button>
    <button type="submit"> Upload</button>
  </form>
</template>

<style scoped>
</style>
