<script setup lang="ts">
import { ref, type Ref, watch } from 'vue';
import type { Game } from '../types.ts';
import { apiStore } from '@/util/apiStore.ts';
import GameComponent from '@/components/GameComponent.vue';
import CriticList from '@/components/CriticList.vue';
import GameFormComponent from '@/components/GameFormComponent.vue';
import {useRoute} from "vue-router";

const gameList: Ref<Array<Game> | 'loading' | 'failed'> = ref('loading');
const selectedGame: Ref<Game | null> = ref(null);
const gameFormDisplayed = ref(false);
const route = useRoute();

const props = defineProps<{
  adminMode?: boolean,
}>();

// TODO : A supprimer une fois cette partie de l'api complété

const brawlstars = ref<Game>({
  approved: false,
  averageNote: 4.3,
  description: 'Big game',
  developer: 'Supercell',
  gameMode: 'Singleplayer',
  genre: 'Adventure',
  id: 1,
  images: [
    'https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg',
    'https://www.androidpolice.com/wp-content/uploads/2018/06/unnamed-1-7.png',
    'https://image.winudf.com/v2/image1/Y29tLnN1cGVyY2VsbC5icmF3bHN0YXJzX3NjcmVlbl8xM18xNTY3MTg5NzczXzA4NA/screen-13.jpg?fakeurl=1&type=.jpg'
  ],
  license: "Assassin's creed",
  name: 'Brawl Stars',
  platform: ['Linux', 'Android'],
  pochette: 'https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg',
  price: 0,
  publisher: 'Matteo',
  releaseDate: '2021-09-15',
  targetAge: 7,
});

const minecraft = ref<Game>({
  approved: true,
  averageNote: 4.7,
  description: 'Sandbox building game',
  developer: 'Mojang Studios',
  gameMode: 'Singleplayer / Multiplayer',
  genre: 'Sandbox',
  id: 2,
  images: [
    'https://upload.wikimedia.org/wikipedia/en/5/51/Minecraft_cover.png',
    'https://www.minecraft.net/content/dam/minecraft/pmp/minecraft-main.jpg',
  ],
  license: 'Minecraft',
  name: 'Minecraft',
  platform: ['Windows', 'Linux', 'Mac', 'Android', 'iOS', 'Xbox', 'PlayStation'],
  pochette: 'https://upload.wikimedia.org/wikipedia/en/5/51/Minecraft_cover.png',
  price: 26.95,
  publisher: 'Mojang Studios',
  releaseDate: '2011-11-18',
  targetAge: 7,
});

const valorant = ref<Game>({
  approved: false,
  averageNote: 4.5,
  description: 'Tactical shooter game',
  developer: 'Riot Games',
  gameMode: 'Multiplayer',
  genre: 'FPS',
  id: 3,
  images: [
    'https://upload.wikimedia.org/wikipedia/en/e/e0/Valorant_cover_art.jpg',
    'https://media.contentapi.ea.com/content/dam/ea/valorant/images/2020/06/valorant-key-art-hero-1920x1080.jpg',
  ],
  license: 'Valorant',
  name: 'Valorant',
  platform: ['Windows'],
  pochette: 'https://upload.wikimedia.org/wikipedia/en/e/e0/Valorant_cover_art.jpg',
  price: 0,
  publisher: 'Riot Games',
  releaseDate: '2020-06-02',
  targetAge: 16,
});

const loadGames = async () => {
  //apiStore.getAll('games').then((data) => gameList.value = data as Array<Game>).catch(() => gameList.value = 'failed')

  //TODO À SUPPRIMER QUAND L'API FONCTIONNE
  gameList.value =[minecraft.value, brawlstars.value, valorant.value];

  //if adminMode
  if (props.adminMode && Array.isArray(gameList.value)){
    gameList.value = gameList.value.filter(game => !game.approved)
  }
}

// to reload the list
loadGames();
watch(() => route.path, () =>{
  loadGames();
})


function selectGame(game: Game) {
  if (selectedGame.value !== game)
    selectedGame.value = game;
  else
    selectedGame.value = null;
}
</script>

<template>
  <div v-if="!props.adminMode">
    <button v-if="!gameFormDisplayed" @click="gameFormDisplayed = true"> Submit a Game</button>
    <GameFormComponent v-else @hide-form="gameFormDisplayed = false"/>
  </div>

  <main>
    <div class="game-list">
      <p v-if="gameList == 'loading'"><i>Fetching critics for this Game</i></p>
      <p v-else-if="gameList == 'failed'"><i>Game critics could not be loaded</i></p>

      <GameComponent v-for="game in gameList" :game="game" @select-game="(gameToSelect) => selectGame(gameToSelect)" :admin-mode="props.adminMode" @loadGames="loadGames" v-else/>
    </div>

    <div class="critic-list" v-if="selectedGame">
      <CriticList :id-type="('game')" :id="(selectedGame.id as string)"/>
    </div>
  </main>
</template>

<style scoped>
  main {
    display: flex;
    flex-direction: row;
  }

  .game-list, .critic-list {
    flex: 1;
  }
</style>
