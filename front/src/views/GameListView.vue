<script setup lang="ts">
import { ref, type Ref } from 'vue';
import type { Game } from '../types.ts';
import { apiStore } from '@/util/apiStore.ts';
import GameComponent from '@/components/GameComponent.vue';
import CriticList from '@/components/CriticList.vue';
import GameFormComponent from '@/components/GameFormComponent.vue';
import NavButton from '@/components/NavButton.vue';

const gameList: Ref<Array<Game> | 'loading' | 'failed'> = ref('loading');
const selectedGame: Ref<Game | null> = ref(null);
const gameFormDisplayed = ref(false);

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

function selectGame(game: Game) {
  if (selectedGame.value !== game)
    selectedGame.value = game;
  else
    selectedGame.value = null;
}
</script>

<template>
  <br>
  <NavButton v-if="!gameFormDisplayed" @click="gameFormDisplayed = true"> Submit a Game</NavButton>
  <GameFormComponent v-else @hide-form="gameFormDisplayed = false"/>
  <main>
    <div class="game-list">
      <p v-if="gameList == 'loading'"><i>Fetching Game List</i></p>
      <p v-else-if="gameList == 'failed'"><i>Game List could not be loaded</i></p>
      <GameComponent v-for="game in gameList" :is-selected="selectedGame === game" :game="game" @select-game="(gameToSelect) => selectGame(gameToSelect)" v-else />
    </div>

    <div class="critic-list" v-if="selectedGame">
      <CriticList :id-type="('game')" :id="(selectedGame.id as string)"/>
    </div>
  </main>
</template>

<style scoped>
  main {
    display: flex;
    flex-direction: row;
  }

  .game-list, .critic-list {
    flex: 1;
  }
  .critic-list {
    border-left: 3px solid rgb(0, 204, 255);
  }
  .game-list {
    display: flex;
    flex-direction: column;
    gap: 0.5em;
  }
</style>