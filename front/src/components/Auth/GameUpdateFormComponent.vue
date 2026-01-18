<script setup lang="ts">
import { ref, watch } from 'vue'
import { apiStore } from '@/util/apiStore'
import type { Game } from '@/types'
import {addNotif} from "@/util/notifStore.ts";

const props = defineProps<{
  game: Game
}>()

const emit = defineEmits<{
  (e: 'updated'): void
}>()

const actualGame = ref<Game>({
  id: 0,
  name: '',
  publisher: '',
  description: '',
  releaseDate: '',
  developper: '',
  gameMode: '',
  targetAge: 0,
  genre: '',
  licence: '',
  price: 0,
  plateform: [],
  images: [],
  pochette: '',
  approved: false,
  averageNote: 0
})

watch(
  () => props.game,
  (game) => {
    if (!game) return

    actualGame.value = {
      id: game.id ?? 0,
      name: game.name ?? '',
      publisher: game.publisher ?? '',
      description: game.description ?? '',
      releaseDate: game.releaseDate ?? '',
      developper: game.developper ?? '',
      gameMode: game.gameMode ?? '',
      targetAge: game.targetAge ?? 0,
      genre: game.genre ?? '',
      licence: game.licence ?? '',
      price: game.price ?? 0,
      plateform: Array.isArray(game.plateform) ? [...game.plateform] : [],
      images: Array.isArray(game.images) ? [...game.images] : [],
      pochette: game.pochette ?? '',
      approved: game.approved ?? false,
      averageNote: game.averageNote ?? 0
    }
  },
  { immediate: true }
)

function removeplateform(index: number) {
  actualGame.value.plateform.splice(index, 1)
}

function removeImage(index: number) {
  actualGame.value.images.splice(index, 1)
}

function updateGame() : void {
  if (props.game) {
    apiStore.updateResource('games', props.game.id as string, actualGame.value, 'PATCH') //
      .then(res => {
        if (res.success) {
          addNotif({autoRemoved: true, type: 'success', message: "Your Game has been updated"});
        } else {
          addNotif({
            autoRemoved: false,
            type: 'error',
            message: "Your Game could not be updated : " + res.error
          });
        }
      });
  } else {
    addNotif({autoRemoved: false, type: 'error', message: "Your game does not exist."})
  }
}

</script>
<template>
  <form @submit.prevent="updateGame">
    <h2>Update game</h2>

    <label>Name</label>
    <input v-model="actualGame.name">

    <label>Publisher</label>
    <input v-model="actualGame.publisher">

    <label>Description</label>
    <textarea v-model="actualGame.description" />

    <label>Release date</label>
    <input type="date" v-model="actualGame.releaseDate">

    <label>developper</label>
    <input v-model="actualGame.developper">

    <label>Game mode</label>
    <input v-model="actualGame.gameMode">

    <label>Target age</label>
    <input type="number" v-model.number="actualGame.targetAge">

    <label>Genre</label>
    <input v-model="actualGame.genre">

    <label>licence</label>
    <input v-model="actualGame.licence">

    <label>Price</label>
    <input type="number" v-model.number="actualGame.price">

    <p><b>plateforms</b></p>
    <ul>
      <li v-for="(_, index) in actualGame.plateform" :key="index">
        <input v-model="actualGame.plateform[index]">
        <button type="button" @click="removeplateform(index)">✖</button>
      </li>
      <li>
        <button type="button" @click="actualGame.plateform.push('')">
          Add plateform
        </button>
      </li>
    </ul>

    <p><b>Images</b></p>
    <ul>
      <li v-for="(_, index) in actualGame.images" :key="index">
        <input v-model="actualGame.images[index]">
        <button type="button" @click="removeImage(index)">✖</button>
      </li>
      <li>
        <button type="button" @click="actualGame.images.push('')">
          Add image
        </button>
      </li>
    </ul>

    <label>Pochette</label>
    <input v-model="actualGame.pochette">

    <button type="submit">Update</button>
  </form>
</template>
