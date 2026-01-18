<script setup lang="ts">
import type { Game } from '../types.ts';
import { apiStore, loggedInUserFavGameIds } from "@/util/apiStore.ts";
import { addNotif } from "@/util/notifStore.ts";
import { computed, ref } from "vue";
import GameFormComponent from "@/components/GameFormComponent.vue";
import {addToFav, delFromFav} from "@/func.ts";
import GameUpdateFormComponent from "@/components/Auth/GameUpdateFormComponent.vue";

const emit = defineEmits<{ selectGame: [gameToSelect: Game], loadGames: [] }>();
const props = defineProps<{
  game: Game,
  adminMode?: 'pending' | 'validated',
}>();

const isFavorite = computed(() => {
  if (loggedInUserFavGameIds.value)
    return loggedInUserFavGameIds.value.includes(props.game.id as string);
  else
    return false;

});

const isEditing = ref(false)

function deleteGame(game: Game){
  apiStore.deleteResource('games', game.id as string).then((data) => {
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

</script>
<template>
  <div
    v-if="!isEditing"
    class="game-component"
    @click="$emit('selectGame', props.game)"
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
      <!-- <button v-if="!adminMode" @click="$emit('selectGame', game)">View critics</button> -->
      <button @click.stop="addToFav(game)" v-if="adminMode !== 'pending' && !isFavorite">Add to favorites</button>
      <button @click.stop="delFromFav(game)" v-if="adminMode !== 'pending' && isFavorite">Remove from favorites</button>
    </div>

    <div v-if="adminMode" class="buttons">
      <button class="delete" @click.stop="() => deleteGame(game)">
        Delete
      </button>

      <button
        class="accept"
        v-if="adminMode === 'pending'"
        @click.stop="() => acceptGame(game)"
      >
        Accept
      </button>

      <button
        class="edit"
        v-if="adminMode === 'validated'"
        @click.stop="state(true)"
      >
        Edit
      </button>
    </div>
  </div>

  <div v-if="isEditing">
    <h2>Editing {{ game.name }}</h2>
    <button class="edit" @click="state(false) ">Cancel Editing of {{game.name}}</button>
    <GameUpdateFormComponent :mode="'update'" :game="game"/>
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
    background-color: gray
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
