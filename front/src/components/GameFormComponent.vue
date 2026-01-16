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
    <h3> Submit a new Game</h3>
    <div class="fields-container">
      <div class="left">
  
        <p>
          <label for="name"><b> Name : </b></label>
          <input id="name" v-model="newGame.name" ></input>
        </p>
  
        <p>
          <label for="pochette"><b> Pochette Link : </b></label>
          <input id="pochette" v-model="newGame.pochette" ></input>
          <ImagePreview :link="newGame.pochette"></ImagePreview>
        </p>
  
        <p>
          <label for="publisher"><b> Publisher : </b></label>
          <input id="publisher" v-model="newGame.publisher" ></input>
        </p>
  
        <p>
          <label for="developer"><b> Developer : </b></label>
          <input id="developer" v-model="newGame.developer" ></input>
        </p>
  
        <p>
          <label for="description"><b> Description :</b></label>
          <br>
          <textarea id="description" v-model="newGame.description" ></textarea>
        </p>
  
        <p>
          <label><b>Price : </b></label>
          <input v-model="newGame.price" type="number">
        </p>
      
      </div>
  
      <div class="right">
        <p>
          <label for="genre"><b> Genre : </b></label>
          <input id="genre" v-model="newGame.genre" ></input>
        </p>
    
        <p>
          <label for="gamemode"><b> Gamemode : </b></label>
          <input id="gamemode" v-model="newGame.gameMode" ></input>
        </p>
    
        <p>
          <label for="age"><b>Targeted age : </b></label>
          <input id="age" v-model="newGame.targetAge" type="number">
        </p>
    
        <p>
          <label for="license"><b> License : </b></label>
          <input id="license" v-model="newGame.license">
        </p>
  
        <p>
          <label for="date"><b> Release date : </b></label>
          <input id="date" v-model="newGame.releaseDate">
        </p>
  
        <p><b> Platforms :</b></p>
        <ul>
          <li v-for="(_, index) in newGame.platform" > <input v-model="newGame.platform[index]"> <button type="button" @click="removePlatform(index)">remove</button></li>
          <li><NavButton @click="newGame.platform.push('')">Add platform</NavButton></li>
        </ul>
    
        <p><b> Additional images :</b></p>
        <ul>
          <li v-for="(_, index) in newGame.images" >
            <input v-model="newGame.images[index]"> <button type="button" @click="removeImage(index)">remove</button>
            <ImagePreview :link="newGame.images[index]"></ImagePreview>
          </li>
          <li><NavButton @click="newGame.images.push('')">Add image link</NavButton></li>
        </ul>
      </div>
    </div>

    <button type="button" @click="$emit('hideForm')"> Cancel</button>
    <button type="submit"> Upload</button>

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
