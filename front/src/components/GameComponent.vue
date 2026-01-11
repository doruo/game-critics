<script setup lang="ts">
import type { Game } from '../types.ts';
import {apiStore} from "@/util/apiStore.ts";
import {addNotif} from "@/util/notifStore.ts";
import {ref} from "vue";

const props = defineProps<{
  game: Game,
  adminMode?: boolean,
}>();


const editedGame = ref({
  id: props.game.id,
  name: props.game.name,
  publisher: props.game.publisher,
  description: props.game.description,
  releaseDate: props.game.releaseDate,
  developer: props.game.developer,
  averageNote: props.game.averageNote,
  gameMode: props.game.gameMode,
  targetAge: props.game.targetAge,
  genre: props.game.genre,
  license: props.game.license,
  price: props.game.price,
  platform: props.game.platform,
  images: props.game.images,
  pochette: props.game.pochette,
  approved: true
});

const emit = defineEmits<{selectGame: [gameToSelect: Game], loadGames: void}>();

function manageGame(game: Game, type: 'accept' | 'reject'){
  if (type=="reject"){
    apiStore.deleteResource('game', game.id as string).then((data) => {
      if (data.success){
        addNotif({autoRemoved: true, type: 'success', message: "The game has been deleted"})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The game could not been deleted"})
      }
    });
    emit("loadGames");
  }

  if (type=="accept"){
    apiStore.patchResource('game', game.id as string, editedGame.value).then((data) => {
      if (data.success){
        addNotif({autoRemoved: true, type: 'success', message: "The game has been accepted."})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The game could not been accepted"})
      }
    });
    emit("loadGames");
  }

}
</script>

<template>
  <div class="game-component" @click="$emit('selectGame', game)">
    <img class="pochette" :src="game.pochette" height="150" :alt="('Pochette du jeu ' + game.name)" v-if="game.pochette">
    <div class="right">
      <h2><RouterLink :to="{name:'gameDetail', params: {id: game.id}}">{{ game.name }}</RouterLink></h2>
      <p><i>Published by </i> {{ game.publisher }}</p>
      <p>Average note : {{ game.averageNote }}</p>
    </div>
    <div v-if="adminMode" class="buttons">
      <button class="accept" @click="() => manageGame(game, 'accept')">Accept</button>
      <button class="reject" @click="() => manageGame(game, 'reject')">Reject</button>
    </div>
  </div>
</template>



<style scoped>
  .game-component {
    display: flex;
    flex-direction: row;
  }

  .buttons{
    align-content: center;
    padding: 40px;
  }

  .accept {
    height: 40px;
    background-color: greenyellow;
  }

  .reject {
    height: 40px;
    background-color: red;
  }

  .game-component:hover {
    background-color: gray;
  }

  .right {
    width: max-content;
  }

  .image-pochette {
    min-height: 100%;
  }
</style>
