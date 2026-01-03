<script setup lang="ts">
import { ref } from 'vue';
import { apiStore } from '@/util/apiStore';
import { addNotif } from '@/util/notifStore';

  const newUser = ref({login: '', email: '', plainPassword: ''});
  const emit = defineEmits<{
    createError: [message: string],
  }>();

function connect(): void {
  apiStore.createRessource('utilisateurs', newUser.value)
  .then((data) => {
    if (data.success) {
      addNotif({autoRemoved: true, type: 'success', message: "New user of login " + newUser.value.login + " has been created"});
    }
    else {
      // TODO fix le message d'erreur qui ne s'affiche pas correctement
      addNotif({autoRemoved: false, type: 'error', message: "New user could not be created : " + data.error});
      emit('createError', data.error as string);
    }
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
