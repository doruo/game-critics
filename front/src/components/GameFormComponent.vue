<script setup lang="ts">
import { ref, type Ref } from 'vue';
import { apiStore } from '@/util/apiStore.ts';
import { addNotif } from '@/util/notifStore.ts';
import type {Game} from '@/types';

const emit = defineEmits<{
  hideForm: [],
}>();

const props = defineProps<{
  game?: Game,
  update?: boolean,
  create?: boolean,
}>();

let actualGame: Ref<Game> = ref({
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

if (props.update && props.game) {
  apiStore.getById('games', props.game.id as string).then((data) => actualGame.value = data as Game)
    //TODO catch si erreur y a

  actualGame.value.id = props.game.id
  actualGame.value.name = props.game.name
  actualGame.value.publisher = props.game.publisher
  actualGame.value.description = props.game.description
  actualGame.value.releaseDate = props.game.releaseDate
  actualGame.value.developer = props.game.developer
  actualGame.value.gameMode = props.game.gameMode
  actualGame.value.targetAge = props.game.targetAge
  actualGame.value.genre = props.game.genre
  actualGame.value.license = props.game.license
  actualGame.value.price = props.game.price
  actualGame.value.platform = props.game.platform
  actualGame.value.images = props.game.images
  actualGame.value.pochette = props.game.pochette
  actualGame.value.approved = props.game.approved
  actualGame.value.averageNote = props.game.averageNote
}


function uploadGame() : void {
  apiStore.createRessource('games', actualGame.value)
  .then(res => {
    if (res.success) {
      addNotif({autoRemoved: true, type: 'success', message: "Your Game has been submitted"});
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "Your GaMe could not be submitted : " + res.error});
    }
  });
}

function updateGame() : void {
  if (props.game) {
    apiStore.patchResource('games', props.game.id as string, actualGame.value) //
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

function removePlatform(indexToRemove: number) {
  actualGame.value.platform = actualGame.value.platform.filter((_, index) => index !== indexToRemove);
}

function removeImage(indexToRemove: number) {
  actualGame.value.images = actualGame.value.images.filter((_, index) => index !== indexToRemove);
}
</script>
<template>
  <form v-if="props.create" @submit.prevent="uploadGame" class="critic-form">
    <p><b> Name :</b></p>
    <input v-model="actualGame.name" ></input>

    <p><b> Pochette Link :</b></p>
    <input v-model="actualGame.pochette" ></input>
    <span>Preview :</span>
    <img :src="actualGame.pochette" height="100" alt="L'image n'a pas pu être récupérée">

    <p><b> Publisher :</b></p>
    <input v-model="actualGame.publisher" ></input>

    <p><b> Developer :</b></p>
    <input v-model="actualGame.developer" ></input>

    <p><b> Description :</b></p>
    <textarea v-model="actualGame.description" ></textarea>

    <p> Price : <input v-model="actualGame.price" type="number"> $</p>

    <p><b> Genre :</b></p>
    <input v-model="actualGame.genre" ></input>

    <p><b> Gamemode :</b></p>
    <input v-model="actualGame.gameMode" ></input>

    <p> Targeted age : <input v-model="actualGame.targetAge" type="number"></p>

    <p> License : <input v-model="actualGame.license"></p>
    <p> Release date : <input v-model="actualGame.releaseDate" type="date"></p>
    <p><b> Platforms :</b></p>
    <ul>
      <li v-for="(_, index) in actualGame.platform" > <input v-model="actualGame.platform[index]"> <button @click="removePlatform(index)">remove</button></li>
      <li><button @click="actualGame.platform.push('')">Add platform</button></li>
    </ul>

    <p><b> Additional images :</b></p>
    <ul>
      <li v-for="(_, index) in actualGame.images" >
        <input v-model="actualGame.images[index]"> <button @click="removeImage(index)">remove</button>
        <span> Preview: </span>
        <img :src="actualGame.images[index]" height="100" alt="L'image n'a pas pu être récupérée">
      </li>
      <li><button @click="actualGame.images.push('')">Add image link</button></li>
    </ul>

    <button @click="$emit('hideForm')"> Cancel</button>
    <button type="submit"> Upload</button>
  </form>

  <form v-if="props.update" @submit.prevent="updateGame" class="critic-form">
    <p><b> Name :</b></p>
    <input v-model="actualGame.name" ></input>

    <p><b> Pochette Link :</b></p>
    <input v-model="actualGame.pochette" ></input>
    <span>Preview :</span>
    <img :src="actualGame.pochette" height="100" alt="L'image n'a pas pu être récupérée">

    <p><b> Publisher :</b></p>
    <input v-model="actualGame.publisher" ></input>

    <p><b> Developer :</b></p>
    <input v-model="actualGame.developer"></input>

    <p><b> Description :</b></p>
    <textarea v-model="actualGame.description" ></textarea>

    <p> Price : <input v-model="actualGame.price" type="number"> $</p>

    <p><b> Genre :</b></p>
    <input v-model="actualGame.genre" ></input>

    <p><b> Gamemode :</b></p>
    <input v-model="actualGame.gameMode" ></input>

    <p> Targeted age : <input v-model="actualGame.targetAge" type="number"></p>

    <p> License : <input v-model="actualGame.license"></p>
    <p> Release date : <input v-model="actualGame.releaseDate" type="date"></p>
    <p><b> Platforms :</b></p>
    <ul>
      <li v-for="(_, index) in actualGame.platform" > <input v-model="actualGame.platform[index]"> <button @click="removePlatform(index)">remove</button></li>
    </ul>
    <li><button @click="actualGame.platform.push('')">Add platform</button></li>


    <p><b> Additional images :</b></p>
    <ul>
      <li v-for="(_, index) in actualGame.images" >
        <input v-model="actualGame.images[index]"> <button @click="removeImage(index)">remove</button>
        <span> Preview: </span>
        <img :src="actualGame.images[index]" height="100" alt="L'image n'a pas pu être récupérée">
      </li>
      <li><button @click="actualGame.images.push('')">Add image link</button></li>
    </ul>

    <button type="submit"> Update</button>
  </form>
</template>

<style scoped>
</style>
