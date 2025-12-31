<script setup lang="ts">
import { ref, watchEffect, type Ref } from 'vue';
import type { Critic } from '../types.ts';
import { apiStore } from '@/util/apiStore.ts';
import CriticComponent from './CriticComponent.vue';

const emit = defineEmits<{
  numberOfCritics: [number: number];
}>();

const props = defineProps<{
  id: string,
  idType: 'game' | 'user',
}>();

const criticList: Ref<Array<Critic> | 'loading' | 'failed'> = ref('loading');

watchEffect(() => {
  if (typeof criticList.value !== 'string')
    emit('numberOfCritics', criticList.value.length);
});

watchEffect(() => {
  if (props.idType === 'game') {
    apiStore.getAllById('games', props.id, 'critics')
    .then((data) => criticList.value = data as Array<Critic>)
    .catch(() => criticList.value = 'failed');
  }

  else if (props.idType === 'user') {
    apiStore.getAllById('users', props.id, 'critics')
    .then((data) => criticList.value = data as Array<Critic>)
    .catch(() => criticList.value = 'failed');
  }
})

// TODO : A supprimer une fois cette partie de l'api complété
/*
criticList.value = [
  {
    id: 1,
    message: "Nul",
    author: {id: 1, email: "e@e.e", login: "test"},
    game: {id:0, averageNote:0, name:'', publisher:''},
    note: 2,
    date: "2023-09-15T12:02:09.037Z",
  },
  {
    id: 2,
    message: "Bien",
    author: {id: 1, email: "e@e.e", login: "test"},
    game: {id:0, averageNote:0, name:'', publisher:''},
    note: 4,
    date: "2029-09-15T12:02:09.037Z",
  },
]
*/
</script>

<template>
  <p v-if="criticList == 'loading'"><i>Fetching critics for this Game</i></p>
  <p v-else-if="criticList == 'failed'"><i>Game critics could not be loaded</i></p>
  <CriticComponent v-for="critic in criticList" :critic="critic" :display-for="props.idType" v-else/>
</template>

<style scoped>
</style>
