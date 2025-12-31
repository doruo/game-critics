<script setup lang="ts">
import { ref } from 'vue';
import { apiStore } from '@/util/apiStore';
import type { User } from '@/types';

const connectingUser = ref({login: '', password: ''});
  const emit = defineEmits<{
    login: [user: User],
    loginError: [message: string],
  }>();

function connect(): void {
  apiStore.login(connectingUser.value.login, connectingUser.value.password)
  .then((data) => {
    if (data.success && data.user)
      emit('login', data.user);
    else if (data.error)
      emit('loginError', data.error);
  });
}
</script>

<template>
  <h3> Login to an existing account</h3>
  <form @submit.prevent="connect" class="content">
    <label>Login</label>
    <input v-model="connectingUser.login" >
    <label>Mot de passe</label>
    <input type="password" v-model="connectingUser.password" > 

    <button type="submit"> Connexion</button>
  </form>
</template>

<style scoped>
</style>
