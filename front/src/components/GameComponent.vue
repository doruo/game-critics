<script setup lang="ts">
import type { Game } from '../types.ts';
import { apiStore } from "@/util/apiStore.ts";
import { addNotif } from "@/util/notifStore.ts";
import { ref } from "vue";
import GameFormComponent from "@/components/GameFormComponent.vue";
import {alreadyOnFav, testingFavGame, addToFav, delFromFav} from "@/func.ts";

const emit = defineEmits<{ selectGame: [gameToSelect: Game], loadGames: void }>();
const props = defineProps<{
  game: Game,
  adminMode?: 'pending' | 'validated'
}>();

let isEditing = ref(false)
/*const editedGame = ref({
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
});*/ // TODO a supp plus tard si pas utilisé

function deleteGame(game: Game){
  apiStore.deleteResource('game', game.id as string).then((data) => {
    addNotif({
      autoRemoved: true,
      type: data.success ? 'success' : 'error',
      message: data.success
        ? "The game has been deleted"
        : "The game could not been deleted"
    })
  });
  emit("loadGames");
}
function acceptGame(game: Game){
  apiStore.updateResource('games', game.id as string, {approved: true}, 'PATCH').then((data) => {
    addNotif({
      autoRemoved: true,
      type: data.success ? 'success' : 'error',
      message: data.success
        ? "The game has been accepted."
        : "The game could not been accepted"
    })
  });
  emit("loadGames");
}
function state(editing: boolean) {
  isEditing.value = editing
}
testingFavGame(props.game);


</script>
<template>
  <div
    v-if="!isEditing"
    class="game-component"
  >
    <img
      class="pochette"
      :src="game.pochette"
      height="150"
      :alt="('Pochette du jeu ' + game.name)"
      v-if="game.pochette"
    >

    <div class="right">
      <h2>
        <RouterLink :to="{ name: 'gameDetail', params: { id: game.id } }">
          {{ game.name }}
        </RouterLink>
      </h2>
      <p><i>Published by </i> {{ game.publisher }}</p>
      <p>Average note : {{ game.averageNote }}</p>
      <button v-if="!adminMode" @click="$emit('selectGame', game)">View critics</button>
      <button @click="addToFav(game)" v-if="!(adminMode == 'pending') && !(alreadyOnFav)">Add to favorit</button>
      <button @click="delFromFav(game)" v-if="!(adminMode == 'pending') && alreadyOnFav">Delete from favorit</button>
    </div>

    <div v-if="adminMode" class="buttons">
      <button class="delete" @click="() => deleteGame(game)">
        Delete
      </button>

      <button
        class="accept"
        v-if="adminMode === 'pending'"
        @click="() => acceptGame(game)"
      >
        Accept
      </button>

      <button
        class="edit"
        v-if="adminMode === 'validated'"
        @click="state(true)"
      >
        Edit
      </button>
    </div>
  </div>

  <div v-if="isEditing">
    <h2>Editing {{ game.name }}</h2>
    <button class="edit" @click="state(false)">Cancel Editing of {{game.name}}</button>
    <GameFormComponent :mode="'update'" :game="game"/>
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
  .edit {
    height: 40px;
    background-color: gray
  }

  .delete {
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

