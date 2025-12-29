<script setup lang="ts">
import type { Critic } from '../types.ts';

defineProps<{
  critic: Critic,
}>();
</script>

<template>
    <hr>
    <p>{{ critic.message }}</p>
    <p><i>Published by </i> {{ critic.author.login }} at {{ (new Date(critic.date)).toLocaleString("fr") }}</p>
    <p>Note : {{ critic.note }} Stars</p>
</template>

<style scoped>
</style>
