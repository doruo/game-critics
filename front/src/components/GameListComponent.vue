<script setup lang="ts">
import { ref, type Ref, watch } from 'vue';
import type { Game } from '../types.ts';
import { useRoute } from "vue-router";
import {minecraft, valorant, brawlstars} from "@/mock.ts";
import GameComponent from "@/components/GameComponent.vue";
import GameFormComponent from './GameFormComponent.vue';
import CriticList from './CriticList.vue';
import { apiStore } from '@/util/apiStore.ts';
import NavButton from './NavButton.vue';

const gameList: Ref<Array<Game> | 'loading' | 'failed'> = ref('loading');
const selectedGame: Ref<Game | null> = ref(null);
const gameFormDisplayed = ref(false);
const route = useRoute();

const props = defineProps<{
  adminMode?: 'pending' | 'validated',
}>();

const loadGames = async () => {
  const routeToUse = props.adminMode ? 'games?approved=false' : 'games'
  // apiStore.getAll(routeToUse).then((data) => gameList.value = data as Array<Game>).catch(() => gameList.value = 'failed')
  //TODO À SUPPRIMER QUAND L'API FONCTIONNE
  gameList.value = [minecraft.value, brawlstars.value, valorant.value];

  if (props.adminMode && Array.isArray(gameList.value)) {
    if (props.adminMode === 'pending') {
      gameList.value = gameList.value.filter(game => !game.approved)
    } else if (props.adminMode === 'validated') {
      gameList.value = gameList.value.filter(game => game.approved)
    }
  } else {
    gameList.value = gameList.value.filter(game => game.approved)
  }
}

loadGames();
watch(() => route.path, () => {
  loadGames();
})

function selectGame(game: Game) {
  if (selectedGame.value !== game)
    selectedGame.value = game;
  else
    selectedGame.value = null;
}
</script>
<template>
  <div v-if="!props.adminMode">
    <NavButton v-if="!gameFormDisplayed" @click="gameFormDisplayed = true"> Submit a Game</NavButton>
    <GameFormComponent v-else @hide-form="gameFormDisplayed = false" :mode="'create'"/>
  </div>

  <main>
    <div class="game-list">
      <p v-if="gameList == 'loading'"><i>Fetching Games</i></p>
      <p v-else-if="gameList == 'failed'"><i>Games could not be loaded</i></p>

      <GameComponent
        v-else
        v-for="game in gameList"
        :game="game"
        @select-game="(gameToSelect) => selectGame(gameToSelect)"
        :admin-mode="props.adminMode"
        @loadGames="loadGames"
      />
    </div>

    <div class="critic-list" v-if="selectedGame && !props.adminMode">
      <h2>Critics of {{selectedGame.name}}</h2>
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
