<script setup lang="ts">

  const props = defineProps<{
    to?: string,
  }>();
</script>

<template>

<RouterLink class="nav-button" :to="to" v-if="to">
  <div>
    <slot></slot>
  </div>
  <div class="bar" />
</RouterLink>

<div class="nav-button" v-else>
  <div>
    <slot></slot>
  </div>
  <div class="bar" />
</div>

</template>

<style scoped>
  .nav-button {
    text-decoration: none;
    color: black;
    display: flex;
    flex-direction: column;
    padding: 0.5em;
    border-radius: 15px;
    transition: 1s;
    cursor: pointer;
    border: 3px solid rgba(0, 204, 255, 0.2);
    width: fit-content;
  }

    .nav-button .bar {
      background-image: linear-gradient(90deg, #0ea8e5, #2a2af1 85%);
      height: 3px;
      width: 0%;
    }
    .nav-button:hover .bar {
      animation: nav-button-hover 1s linear both;
    }

  .nav-button:hover {
    background-color: rgba(0, 0, 0, 0.05);
    border: 3px solid transparent;
  }

  @keyframes nav-button-hover{
    0%{
      width: 0%;
    }
    30%{
      width: 75%;
    }
    90%{
      width: 93%;
    }
    100%{
      width: 100%;
    }
  };
</style>
