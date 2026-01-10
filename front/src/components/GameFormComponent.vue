<script setup lang="ts">
import { ref, type Ref } from 'vue';
import { apiStore } from '@/util/apiStore.ts';
import { addNotif } from '@/util/notifStore.ts';
import type { Game } from '@/types';

const emit = defineEmits<{
  hideForm: [],
}>();

const newGame: Ref<Game> = ref({
    id: 0,
    name: '',
    publisher: '',
    description: '',
    releaseDate: '',
    developer: '',
    gameMode: '',
    targetAge: 0,
    genre: '',
    license: '',
    price: 0,
    platform: [],
    images: [],
    pochette: '',
    approved: false,
    averageNote: 0,
});

function uploadCritic() : void {
  apiStore.createRessource('games', newGame.value)
  .then(res => {
    if (res.success) {
      addNotif({autoRemoved: true, type: 'success', message: "Your Game has been submitted"});
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "Your GaMe could not be submitted : " + res.error});
    }
  });
}

function removePlatform(indexToRemove: number) {
  newGame.value.platform = newGame.value.platform.filter((_, index) => index !== indexToRemove);
}

function removeImage(indexToRemove: number) {
  newGame.value.images = newGame.value.images.filter((_, index) => index !== indexToRemove);
}
</script>

<template>
  <form @submit.prevent="uploadCritic" class="critic-form">
    <p><b> Name :</b></p>
    <input v-model="newGame.name" ></input>

    <p><b> Pochette Link :</b></p>
    <input v-model="newGame.pochette" ></input>
    <span>Preview :</span>
    <img :src="newGame.pochette" height="100" alt="L'image n'a pas pu être récupérée">

    <p><b> Publisher :</b></p>
    <input v-model="newGame.publisher" ></input>

    <p><b> Developer :</b></p>
    <input v-model="newGame.developer" ></input>

    <p><b> Description :</b></p>
    <textarea v-model="newGame.description" ></textarea>

    <p> Price : <input v-model="newGame.price" type="number"> $</p>

    <p><b> Genre :</b></p>
    <input v-model="newGame.genre" ></input>

    <p><b> Gamemode :</b></p>
    <input v-model="newGame.gameMode" ></input>

    <p> Targeted age : <input v-model="newGame.targetAge" type="number"></p>

    <p> License : <input v-model="newGame.license"></p>
    <p> Release date : <input v-model="newGame.releaseDate" type="date"></p>
    <p><b> Platforms :</b></p>
    <ul>
      <li v-for="(_, index) in newGame.platform" > <input v-model="newGame.platform[index]"> <button @click="removePlatform(index)">remove</button></li>
      <li><button @click="newGame.platform.push('')">Add platform</button></li>
    </ul>

    <p><b> Additional images :</b></p>
    <ul>
      <li v-for="(_, index) in newGame.images" >
        <input v-model="newGame.images[index]"> <button @click="removeImage(index)">remove</button>
        <span> Preview: </span>
        <img :src="newGame.images[index]" height="100" alt="L'image n'a pas pu être récupérée">
      </li>
      <li><button @click="newGame.images.push('')">Add image link</button></li>
    </ul>

    <button @click="$emit('hideForm')"> Cancel</button>
    <button type="submit"> Upload</button>
  </form>
</template>

<style scoped>
</style>
