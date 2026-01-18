<script setup lang="ts">
import type { Game } from '../types.ts';
import {apiStore} from "@/util/apiStore.ts";
import {addNotif} from "@/util/notifStore.ts";
import {ref} from "vue";
import GameFormComponent from "@/components/GameFormComponent.vue";

const emit = defineEmits<{selectGame: [gameToSelect: Game], loadGames: []}>();
const props = defineProps<{
  game: Game,
  invalidated?: boolean,
  edit?: boolean,
  adminMode?: boolean
}>();

let isEditing = ref(false)
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

function manageGame(game: Game, type: 'accept' | 'delete'){
  if (type=="delete"){
    apiStore.deleteResource('games', game.id as string).then((data) => {
      if (data.success){
        addNotif({autoRemoved: true, type: 'success', message: "The game has been deleted"})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The game could not been deleted"})
      }
    });
    emit("loadGames");
  }

  if (type=="accept"){
    apiStore.patchResource('games', game.id as string, editedGame.value).then((data) => {
      if (data.success){
        addNotif({autoRemoved: true, type: 'success', message: "The game has been accepted."})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The game could not been accepted"})
      }
    });
    emit("loadGames");
  }

  /*if (type=="edit"){
    apiStore.patchResource('games', game.id as string, editedGame.value).then((data) => {
      if (data.success){
        addNotif({autoRemoved: true, type: 'success', message: "The game has been accepted."})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The game could not been accepted"})
      }
    });
    emit("loadGames");
  }*/

}
function state(editing: boolean){
  if(editing){
    isEditing.value = true
  } else {
    isEditing.value = false
  }
}
</script>

<template>
  <div v-if="!isEditing" class="game-component" @click="!adminMode ? $emit('selectGame', game) : null">
      <img class="pochette" :src="game.pochette" height="150" :alt="('Pochette du jeu ' + game.name)" v-if="game.pochette">
      <div class="right">
        <h2><RouterLink :to="{name:'gameDetail', params: {id: game.id}}">{{ game.name }}</RouterLink></h2>
        <p><i>Published by </i> {{ game.publisher }}</p>
        <p>Average note : {{ game.averageNote }}</p>
      </div>

      <div v-if="adminMode" class="buttons">
        <button class="delete" @click="() => manageGame(game, 'delete')">Delete</button>
        <button class="accept" v-if="invalidated" @click="() => manageGame(game, 'accept')">Accept</button>
        <button class="edit" v-if="edit" @click="state(true)">Edit</button>
      </div>

  </div>
  <div v-if="isEditing">
    <h2>Editing {{game.name}}</h2>
    <GameFormComponent :update="true" :game="game"/>
    <button class="edit" v-if="edit" @click="state(false)">Cancel</button>
  </div>
</template>



<style scoped>
  .game-component {
    display: flex;
    flex-direction: row;
    border-radius: 15px;
  }

  .buttons{
    align-content: center;
    padding: 40px;
  }

  .accept {
    height: 40px;
    background-color: greenyellow;
  }

  .edit {
    height: 40px;
    background-color: gray;
  }

  .delete {
    height: 40px;
    background-color: red;
  }

  .game-component:hover {
    background-color: gray;
  }

  .game-component:hover, .selected {
    background-image: linear-gradient(90deg, white 50%, #d5d5d5 80% );
  }

  .right {
    width: max-content;
  }
  
  .pochette {
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
    padding-right: 0.5em;
    margin-right: 0.5em;
    border-right: 3px solid rgb(0, 204, 255);
  }
</style>
