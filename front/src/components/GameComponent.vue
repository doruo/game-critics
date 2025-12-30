<script setup lang="ts">
import type { Game } from '../types.ts';

defineProps<{
  game: Game,
}>();
</script>

<template>
    <hr>
    <h2>{{ game.name }}</h2>
    <p><i>Published by </i> {{ game.publisher }}</p>
    <p>Average note : {{ game.averageNote }}</p>
</template>

<style scoped>
</style>
