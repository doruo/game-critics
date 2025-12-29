<script setup lang="ts">
import type { Game } from '../types.ts';

defineProps<{
  game: Game,
}>();
</script>

<template>
    <hr>
    <h2><RouterLink :to="{name:'gameDetail', params: {id: game.id}}">{{ game.name }}</RouterLink></h2>
    <p><i>Published by </i> {{ game.publisher }}</p>
    <p>Average note : {{ game.averageNote }}</p>
</template>

<style scoped>
</style>
