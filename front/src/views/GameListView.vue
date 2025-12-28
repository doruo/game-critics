<script setup lang="ts">
import { ref, type Ref } from 'vue';
import type { Game } from '../types.ts';
import { apiStore } from '@/util/apiStore.ts';
import GameComponent from '@/components/GameComponent.vue';

const gameList: Ref<Array<Game>> = ref([]);

apiStore.getAll('games')
.then((data) => gameList.value = data as Array<Game>);

// TODO : A supprimer une fois cette partie de l'api complété
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

</script>

<template>
  <main>
    <GameComponent v-for="game in gameList" :game="game" />
  </main>
</template>
