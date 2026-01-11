<script setup lang="ts">
import GameDetailView from "@/views/GameDetailView.vue";
import type {Game} from "@/types.ts";
import {ref} from "vue";

</script>

<template>
  <nav>
    <RouterLink to="/admin/users/">Users</RouterLink>
    <RouterLink :key="$route.fullPath" to="/admin/games/">Unvalidated games</RouterLink>
  </nav>


</template>
<style scoped>
  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
</style>
