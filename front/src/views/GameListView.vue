<script setup lang="ts">
import { ref, type Ref } from 'vue';
import type { Game } from '../types.ts';
import { apiStore } from '@/util/apiStore.ts';
import GameComponent from '@/components/GameComponent.vue';

const gameList: Ref<Array<Game> | 'loading' | 'failed'> = ref('loading');

apiStore.getAll('games')
.then((data) => gameList.value = data as Array<Game>)
.catch(() => gameList.value = 'failed');

// TODO : A supprimer une fois cette partie de l'api complété
/*
gameList.value = [
  {
    id: 1,
    name: "Brawl Stars",
    publisher: "Supercell",
    averageNote: 5.0,
  },
  {
    id: 2,
    name: "Fallou 76",
    publisher: "Marc",
    averageNote: 1.3,
  },
]
*/

</script>

<template>
  <main>
    <p v-if="gameList == 'loading'"><i>Fetching critics for this Game</i></p>
    <p v-else-if="gameList == 'failed'"><i>Game critics could not be loaded</i></p>
    <GameComponent v-for="game in gameList" :game="game" v-else />
  </main>
</template>
