<script setup lang="ts">
import { ref, type Ref } from 'vue';
import type { Game } from '../types.ts';
import { useRoute } from 'vue-router';
import CriticList from '@/components/CriticList.vue';
import CriticFormComponent from '@/components/CriticFormComponent.vue';
import { alreadyOnFav, addToFav, delFromFav } from "@/func.ts";
import {apiStore} from "@/util/apiStore.ts";

const route = useRoute();
// const props = defineProps<{passedGame?: Ref<Game>}>();

const game: Ref<Game | 'loading' | 'failed'> = ref('loading');
const criticFormDisplayed = ref(false);

//TODO à remettre lorsque l'api fonctionne
// if (!props.passedGame) {
    apiStore.getById('games', route.params.id as string)
    .then((data) => game.value = data as Game)
    .catch(() => game.value = 'failed');
// } else {
//   game.value = props.passedGame.value;
// }
/* 
game.value = {
  approved: true,
  averageNote: 4.3,
  description: 'Big game',
  developper: 'Supercell',
  gameMode: 'Singleplayer',
  genre: 'Adventure',
  id: 1,
  images: ['https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg', 'https://www.androidpolice.com/wp-content/uploads/2018/06/unnamed-1-7.png', 'https://image.winudf.com/v2/image1/Y29tLnN1cGVyY2VsbC5icmF3bHN0YXJzX3NjcmVlbl8xM18xNTY3MTg5NzczXzA4NA/screen-13.jpg?fakeurl=1&type=.jpg'],
  license: 'Assassin\'s creed',
  name: 'Brawl Stars',
  platform: ['Linux', 'Android'],
  pochette: 'https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg',
  price: 0,
  publisher: 'Matteo',
  releaseDate: "2021-09-15",
  targetAge: 7,
}
 */
</script>

<template>
    <p v-if="game == 'loading'"><i>Fetching Game Details</i></p>
    <p v-else-if="game == 'failed'"><i>Game Details could not be loaded</i></p>
    <div class="game-display" v-else>
        <h2> {{ game.name }}</h2>
        <div class="img-and-desc">
            <div class="left">
                <img class="pochette" :src="game.pochette" height="150" :alt="('Pochette du jeu ' + game.name)" v-if="game.pochette">
                <p> Published by <b> {{ game.publisher }}</b></p>
                <p> Developed by <b> {{ game.developper }}</b></p>
            </div>
            <blockquote> {{ game.description }}</blockquote>
        </div>

        <hr>
        <ul> Playable on :
            <li v-for="platform in game.platform"> {{ platform }}</li>
        </ul>
        <p>Available for {{ game.price }} $</p>

        <div class="additional-info">
            <p>Additional info :</p>
            <ul>
                <li>Genre : {{ game.genre }}</li>
                <li>Gamemode : {{ game.gameMode }}</li>
                <li>Pegi {{ game.targetAge }}</li>
                <li>Licence : {{ game.license ? game.license : 'None' }}</li>
                <li>Released on {{ new Date(game.releaseDate).toLocaleDateString() }}</li>
            </ul>
        </div>

        <div class="image-list" v-if="game.images">
            <img v-for="image, index in game.images" :src="image" height="150" :alt="('image n°' + index)">
        </div>
    </div>

    <br>
    <h2> Avis :</h2>
    <button v-if="!criticFormDisplayed" @click="criticFormDisplayed = true"> Write a critic</button>
    <CriticFormComponent v-else :game="(game as Game)" @hide-form="criticFormDisplayed = false" />

    <CriticList :id-type="('game')" :id="route.params.id as string"/>
</template>

<style scoped>
    hr {
        color: rgb(0, 204, 255);
        background-color: rgb(0, 204, 255);
        height: 2px;
    }

    .game-display {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

     .img-and-desc {
        display: flex;
        max-width: 900px;
        width: 900px;
     }
        .img-and-desc .left {
            width: fit-content;
        }
        .img-and-desc blockquote {
            background-color: #696969;
            border-radius: 10px;
            padding: 0.5em;
            color: white;
            width: 100%;
        }
    .image-list {
        border: 4px groove rgb(119, 119, 119);
        display: flex;
        gap: 1em;
        width: fit-content;
        padding: 0.3em;
        padding-left: 1em;
        padding-right: 1em;
        max-width: 95%;
        margin-left: auto;
        margin-right: auto;
        overflow-y: scroll;
    }

    .additional-info {
        background-color: #696969;
        width: fit-content;
        padding-left: 0.5em;
        padding-right: 7em;
        border-radius: 10px;
        color: white;
    }
</style>
