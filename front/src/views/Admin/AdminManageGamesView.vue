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
<hr>
    <div class="games-column">
      <h2>Manage all validated games</h2>
      <GameListComponent admin-mode="validated" />
    </div>
  </div>
</template>

<style scoped>
.games-container {
  display: flex;
  gap: 2rem; /* espace entre les deux blocs */
}

.games-column {
  flex: 1;
}

hr {
  background-color: rgb(0, 204, 255);
  color: rgb(0, 204, 255);
  width: 2px;
}
</style>
