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
  <form
    @submit.prevent="updateGame"
    class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow-md space-y-6"
  >
    <h2 class="text-2xl font-bold text-center">Update game</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="font-medium">Name</label>
        <input v-model="actualGame.name" class="input" />
      </div>

      <div>
        <label class="font-medium">Publisher</label>
        <input v-model="actualGame.publisher" class="input" />
      </div>
    </div>

    <div>
      <label class="font-medium">Description</label>
      <textarea v-model="actualGame.description" class="input h-28"></textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="font-medium">Release date</label>
        <input type="date" v-model="actualGame.releaseDate" class="input" />
      </div>

      <div>
        <label class="font-medium">Developper</label>
        <input v-model="actualGame.developper" class="input" />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="font-medium">Game mode</label>
        <input v-model="actualGame.gameMode" class="input" />
      </div>

      <div>
        <label class="font-medium">Target age</label>
        <input type="number" v-model.number="actualGame.targetAge" class="input" />
      </div>

      <div>
        <label class="font-medium">Price</label>
        <input type="number" v-model.number="actualGame.price" class="input" />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="font-medium">Genre</label>
        <input v-model="actualGame.genre" class="input" />
      </div>

      <div>
        <label class="font-medium">Licence</label>
        <input v-model="actualGame.licence" class="input" />
      </div>
    </div>

    <div>
      <p class="font-semibold mb-2">Plateforms</p>
      <ul class="space-y-2">
        <li
          v-for="(_, index) in actualGame.plateform"
          :key="index"
          class="flex gap-2"
        >
          <input v-model="actualGame.plateform[index]" class="input flex-1" />
          <button
            type="button"
            @click="removeplateform(index)"
            class="btn-danger"
          >
            ✖
          </button>
        </li>
      </ul>

      <button
        type="button"
        @click="actualGame.plateform.push('')"
        class="btn-secondary mt-2"
      >
        + Add plateform
      </button>
    </div>

    <div>
      <p class="font-semibold mb-2">Images</p>
      <ul class="space-y-2">
        <li
          v-for="(_, index) in actualGame.images"
          :key="index"
          class="flex gap-2"
        >
          <input v-model="actualGame.images[index]" class="input flex-1" />
          <button
            type="button"
            @click="removeImage(index)"
            class="btn-danger"
          >
            ✖
          </button>
        </li>
      </ul>

      <button
        type="button"
        @click="actualGame.images.push('')"
        class="btn-secondary mt-2"
      >
        + Add image
      </button>
    </div>

    <div>
      <label class="font-medium">Pochette</label>
      <input v-model="actualGame.pochette" class="input" />
    </div>

    <div class="text-center pt-4">
      <button type="submit" class="btn-primary px-8">
        Update
      </button>
    </div>
  </form>
</template>
