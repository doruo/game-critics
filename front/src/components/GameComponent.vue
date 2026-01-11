<script setup lang="ts">
import type { Game } from '../types.ts';

defineProps<{
  game: Game,
  isSelected: boolean,
}>();

const emit = defineEmits<{selectGame: [gameToSelect: Game]}>();
</script>

<template>
  <div :class="isSelected ? 'selected' : ''" class="game-component" @click="$emit('selectGame', game)">
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
    border-radius: 15px;
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
