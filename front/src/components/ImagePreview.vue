<script setup lang="ts">

  const props = defineProps<{
    link: string | undefined,
  }>();
</script>

<template>

  <br>
  <div class="image-preview">
    <span>Preview :</span>
    <br>
    <b><img :src="props.link" height="100" alt="L'image n'a pas pu être récupérée"></b>
  </div>

</template>

<style scoped>
    img {
        color: red;
    }
</style>
