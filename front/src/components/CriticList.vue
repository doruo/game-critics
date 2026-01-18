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
    generalMessage: "Bien",
    scenarioMessage: "Bien2",
    soundtrackMessage: "Bien3",
    visualMessage: "Bien4",
    author: {id: 1, email: "e@e.e", login: "Nightwing", roles: []},
    game: { approved: true, averageNote: 4.3, description: 'Big game', developer: 'Supercell', gameMode: 'Singleplayer', genre: 'Adventure', id: 1, images: ['https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg', 'https://www.androidpolice.com/wp-content/uploads/2018/06/unnamed-1-7.png', 'https://image.winudf.com/v2/image1/Y29tLnN1cGVyY2VsbC5icmF3bHN0YXJzX3NjcmVlbl8xM18xNTY3MTg5NzczXzA4NA/screen-13.jpg?fakeurl=1&type=.jpg'], license: 'Assassin\'s creed', name: 'Brawl Stars', platform: ['Linux', 'Android'], pochette: 'https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg', price: 0, publisher: 'Matteo', releaseDate: "2021-09-15", targetAge: 7, },
    note: 2,
    publicationDate: "2023-09-15T12:02:09.037Z",
  },
  {
    id: 2,
    generalMessage: "Bien",
    scenarioMessage: "Bien2",
    soundtrackMessage: "Bien3",
    visualMessage: "Bien4",
    author: {id: 2, email: "e@e.e", login: "Nightwing", roles: []},
    game: { approved: true, averageNote: 4.3, description: 'Big game', developer: 'Supercell', gameMode: 'Singleplayer', genre: 'Adventure', id: 1, images: ['https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg', 'https://www.androidpolice.com/wp-content/uploads/2018/06/unnamed-1-7.png', 'https://image.winudf.com/v2/image1/Y29tLnN1cGVyY2VsbC5icmF3bHN0YXJzX3NjcmVlbl8xM18xNTY3MTg5NzczXzA4NA/screen-13.jpg?fakeurl=1&type=.jpg'], license: 'Assassin\'s creed', name: 'Brawl Stars', platform: ['Linux', 'Android'], pochette: 'https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg', price: 0, publisher: 'Matteo', releaseDate: "2021-09-15", targetAge: 7, },
    note: 4,
    publicationDate: "2029-09-15T12:02:09.037Z",
  },
]
*/

function removeCritic(criticToRemove: Critic) : void {
  if (criticList.value === 'failed' || criticList.value === 'loading')
    return;
  criticList.value = criticList.value.filter((critic) => 
    critic.id !== criticToRemove.id
  )
}
</script>

<template>
  <p v-if="criticList == 'loading'"><i>Fetching critics for this Game</i></p>
  <p v-else-if="criticList == 'failed'"><i>Game critics could not be loaded</i></p>
  <div class="critic-list" v-else>
    <CriticComponent v-for="critic in criticList" :key="critic.id" :critic="critic" :display-for="props.idType" @remove-critic="removeCritic"/>
  </div>
</template>

<style scoped>
  .critic-list {
    width: fit-content;
  }
</style>
