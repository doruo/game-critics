<script setup lang="ts">
import { ref, type Ref, watch } from 'vue';
import type {Game, User} from '../types.ts';
import { useRoute } from "vue-router";
import GameComponent from "@/components/GameComponent.vue";
import GameFormComponent from './GameFormComponent.vue';
import CriticList from './CriticList.vue';
import {apiStore, loggedInUser} from "@/util/apiStore.ts";
import NavButton from './NavButton.vue';

const gameList: Ref<Array<Game> | 'loading' | 'failed'> = ref('loading');
const selectedGame: Ref<Game | null> = ref(null);
const gameFormDisplayed = ref(false);
const route = useRoute();
let page: Ref<number> = ref(1)

 const errorUser : Ref<'' | 'failed' | 'loading'> = ref('loading')

const props = defineProps<{
  adminMode?: 'pending' | 'validated',
  favType?: boolean
}>();

const loadGames = async () => {
  if (props.favType) {
    apiStore.getAllById('users', loggedInUser.value?.id as string, 'favoritesGames')
    .then((data) => gameList.value = data as Array<Game>)
    .catch(() => gameList.value = 'failed')
  } else {
    const routeToUse = props.adminMode === 'pending' ? 'unvalidated' : 'games';
    apiStore.getAll(routeToUse, page.value)
    .then((data) => gameList.value = data as Array<Game>)
    .catch(() => gameList.value = 'failed')
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
  <div v-if="!props.adminMode && !props.favType">
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
