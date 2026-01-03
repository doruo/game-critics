<script setup lang="ts">
import { ref } from 'vue';
import { apiStore } from '@/util/apiStore';
import { addNotif } from '@/util/notifStore';

const connectingUser = ref({login: '', password: ''});
  const emit = defineEmits<{
    loginError: [message: string],
  }>();

function connect(): void {
  apiStore.login(connectingUser.value.login, connectingUser.value.password)
  .then((data) => {
    if (data.success) {
      addNotif({autoRemoved: true, type: 'success', message: "You are now logged in as " + connectingUser.value.login});
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "Failed to log you in : " + data.error});
      emit('loginError', data.error as string);
    }
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
