<script setup lang="ts">
import type { Game } from '../types.ts';

defineProps<{
  game: Game,
}>();

const emit = defineEmits<{selectGame: [gameToSelect: Game]}>();
</script>

<template>
  <div class="game-component" @click="$emit('selectGame', game)">
    <img class="pochette" :src="game.pochette" height="150" :alt="('Pochette du jeu ' + game.name)" v-if="game.pochette">
    <div class="right">
      <h2><RouterLink :to="{name:'gameDetail', params: {id: game.id}}">{{ game.name }}</RouterLink></h2>
      <p><i>Published by </i> {{ game.publisher }}</p>
      <p>Average note : {{ game.averageNote }}</p>
    </div>
  </div>
</template>

<style scoped>
  .game-component {
    display: flex;
    flex-direction: row;
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
