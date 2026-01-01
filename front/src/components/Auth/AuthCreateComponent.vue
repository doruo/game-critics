<script setup lang="ts">
import { ref } from 'vue';
import { apiStore } from '@/util/apiStore';

  const newUser = ref({login: '', email: '', plainPassword: ''});
  const emit = defineEmits<{
    createError: [message: string],
  }>();

function connect(): void {
  apiStore.createRessource('users', newUser.value)
  .then((data) => {
    if (data.error) // TODO fix le message d'erreur qui ne s'affiche pas
      emit('createError', data.error);
  });
}
</script>

<template>
  <h3> Create an account</h3>
  <form @submit.prevent="connect" class="content">
    <label>Login</label>
    <input v-model="newUser.login" >
    <label>Email</label>
    <input v-model="newUser.email" >
    <label>Mot de passe</label>
    <input type="password" v-model="newUser.plainPassword" > 

    <button type="submit"> Create</button>
  </form>
</template>

<style scoped>
</style>
