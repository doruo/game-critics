<script setup lang="ts">
import GameListComponent from "@/components/GameListComponent.vue";
</script>

<template>
  <h1>Management - Games</h1>
  <div class="games-container">
    <div class="games-column">
      <h2>Invalidated games</h2>
      <GameListComponent admin-mode="pending" />
    </div>

    <div class="games-column">
      <h2>Manage all validated games</h2>
      <GameListComponent admin-mode="validated" />
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
