<script setup lang="ts">
import { ref, type Ref } from 'vue';
import { apiStore } from '@/util/apiStore.ts';
import { addNotif } from '@/util/notifStore.ts';
import type { Game } from '@/types';
import ImagePreview from './ImagePreview.vue';
import NavButton from './NavButton.vue';

const emit = defineEmits<{
  hideForm: [],
}>();

const props = defineProps<{
  game?: Game,
  mode: 'update' | 'create';
}>();

let errorMSG : Ref<'' | 'failed' | 'loading'> = ref('loading')
let actualGame: Ref<Game> = ref({
    // id: 0,
    name: '',
    publisher: '',
    description: '',
    releaseDate: '',
    developper: '',
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

if (props.mode == 'update' && props.game) {

  //TODO à modifier quand l'api sera là
  //apiStore.getById('games', props.game.id as string).then((data) => actualGame.value = data as Game).catch(() => errorMSG.value = 'failed')

  errorMSG.value = ''

  actualGame.value.id = props.game.id
  actualGame.value.name = props.game.name
  actualGame.value.publisher = props.game.publisher
  actualGame.value.description = props.game.description
  actualGame.value.releaseDate = props.game.releaseDate
  actualGame.value.developper = props.game.developper
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

function updateOrUpload() : void {
if (props.mode === 'update')
  updateGame()
else
  uploadGame();
}

function uploadGame() : void {
  console.log('FUCK');
  
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
    apiStore.updateResource('games', props.game.id as string, actualGame.value, 'PUT') //
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
  <p v-if="errorMSG == 'loading'"><i>Fetching User Details</i></p>
  <p v-else-if="errorMSG == 'failed'"><i>User Details could not be fetched</i></p>

  <form @submit.prevent="updateOrUpload" class="critic-form">
    <h3> Submit a new Game</h3>
    <div class="fields-container">
      <div class="left">
  
        <p>
          <label for="name"><b> Name : </b></label>
          <input id="name" v-model="actualGame.name" ></input>
        </p>
  
        <p>
          <label for="pochette"><b> Pochette Link : </b></label>
          <input id="pochette" v-model="actualGame.pochette" ></input>
          <ImagePreview :link="actualGame.pochette"></ImagePreview>
        </p>
  
        <p>
          <label for="publisher"><b> Publisher : </b></label>
          <input id="publisher" v-model="actualGame.publisher" ></input>
        </p>
  
        <p>
          <label for="developer"><b> Developer : </b></label>
          <input id="developer" v-model="actualGame.developper" ></input>
        </p>
  
        <p>
          <label for="description"><b> Description :</b></label>
          <br>
          <textarea id="description" v-model="actualGame.description" ></textarea>
        </p>
  
        <p>
          <label><b>Price : </b></label>
          <input v-model="actualGame.price" type="number">
        </p>
      
      </div>
  
      <div class="right">
        <p>
          <label for="genre"><b> Genre : </b></label>
          <input id="genre" v-model="actualGame.genre" ></input>
        </p>
    
        <p>
          <label for="gamemode"><b> Gamemode : </b></label>
          <input id="gamemode" v-model="actualGame.gameMode" ></input>
        </p>
    
        <p>
          <label for="age"><b>Targeted age : </b></label>
          <input id="age" v-model="actualGame.targetAge" type="number">
        </p>
    
        <p>
          <label for="license"><b> License : </b></label>
          <input id="license" v-model="actualGame.license">
        </p>
  
        <p>
          <label for="date"><b> Release date : </b></label>
          <input id="date" type="date" v-model="actualGame.releaseDate">
        </p>
  
        <p><b> Platforms :</b></p>
        <ul>
          <li v-for="(_, index) in actualGame.platform" > <input v-model="actualGame.platform[index]"> <button type="button" @click="removePlatform(index)">remove</button></li>
          <li><NavButton @click="actualGame.platform.push('')">Add platform</NavButton></li>
        </ul>
    
        <p><b> Additional images :</b></p>
        <ul>
          <li v-for="(_, index) in actualGame.images" >
            <input v-model="actualGame.images[index]"> <button type="button" @click="removeImage(index)">remove</button>
            <ImagePreview :link="actualGame.images[index]"></ImagePreview>
          </li>
          <li><NavButton @click="actualGame.images.push('')">Add image link</NavButton></li>
        </ul>
      </div>
    </div>

    <button type="button" @click="$emit('hideForm')"> Cancel</button>
    <button type="submit"> {{ props.mode === 'update' ? 'Update' : 'Upload' }}</button>

  </form>
</template>

<style scoped>
  .fields-container {
    display: flex;
    gap: 1em;
  }
  form {
    background-image: linear-gradient(90deg, white 70%, #d3d3d3 90% );
    border: 3px solid rgb(0, 204, 255);
    border-radius: 15px;
    padding: .5em;
    width: fit-content;
  }
  .left {
    border-right: 2px solid black;
    padding-right: 1em;
    margin-right: 1em;
  }
</style>
