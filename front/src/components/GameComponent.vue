<script setup lang="ts">
import type { Game } from '../types.ts';

defineProps<{
  game: Game,
}>();

const emit = defineEmits<{selectGame: [gameToSelect: Game]}>();
</script>

<template>
  <div class="game-component" @click="$emit('selectGame', game)">
    <hr>
    <h2><RouterLink :to="{name:'gameDetail', params: {id: game.id}}">{{ game.name }}</RouterLink></h2>
    <p><i>Published by </i> {{ game.publisher }}</p>
    <p>Average note : {{ game.averageNote }}</p>
  </div>
</template>

<style scoped>
  .game-component:hover {
    background-color: gray;
  }
</style>
