<script setup lang="ts">
import type { Critic } from '../types.ts';

defineProps<{
  critic: Critic,
  displayFor: 'game' | 'user';
}>();
</script>

<template>
  <div class="user-critic critic" v-if="displayFor === 'user'">
    <hr>
    <p>{{ critic.message }}</p>
    <p><i>Published by </i> <RouterLink :to="`/users/${critic.author.id}`"> {{ critic.author.login }}</RouterLink> at {{ (new Date(critic.date)).toLocaleString("fr") }}</p>
    <p>Note : {{ critic.note }} Stars</p>
  </div>

  <div class="game-critic critic" v-else-if="displayFor === 'game'">
    <hr>
    <p>{{ critic.message }}</p>
    <p><i>For the game : </i> <RouterLink :to="`/games/${critic.game.id}`"> {{ critic.game.name }}</RouterLink> at {{ (new Date(critic.date)).toLocaleString("fr") }}</p>
    <p>Note : {{ critic.note }} Stars</p>
  </div>
</template>

<style scoped>
</style>
