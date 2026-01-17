<script setup lang="ts">

import GameListView from "@/views/GameListView.vue";
</script>

<template>
  <h1>Management - Games</h1>
  <div class="games-container">
    <div class="games-column">
      <h2>Invalidated games</h2>
      <GameListView :admin-mode="true" :invalidated="true" />
    </div>

    <div class="games-column">
      <h2>Manage all validated games</h2>
      <GameListView :admin-mode="true" :edit="true" />
    </div>
  </div>
</template>

<style scoped>
.games-container {
  display: flex;
  justify-content: space-between; /* gauche / droite */
  gap: 2rem; /* espace entre les deux blocs */
}

.games-column {
  width: 48%; /* ou flex: 1 */
  border-style: solid;     /* sinon la bordure ne s’affiche pas */
  border-color: black;
}
</style>
