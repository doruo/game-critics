<script setup lang="ts">
import { ref, watch } from 'vue';
import { apiStore } from '@/util/apiStore';
import { addNotif } from '@/util/notifStore';
import { isAuthDiplayed } from '@/util/authDisplayedStore';

const connectingUser = ref({login: '', password: ''});
  const emit = defineEmits<{
    loginError: [messages: Array<string>],
  }>();

function connect(): void {
  apiStore.login(connectingUser.value.login, connectingUser.value.password)
  .then((data) => {
    if (data.success) {
      addNotif({autoRemoved: true, type: 'success', message: "You are now logged in as " + connectingUser.value.login});
      isAuthDiplayed.value = false;
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "Failed to log you in : " + data.error});
      const errorMess = data.error?.split('\n');
      emit('loginError', errorMess as Array<string>);
    }
  });
}

watch(connectingUser.value, () => {
  let newErrorMessage: Array<string> = [];
  const {login, password} = connectingUser.value;

  if (login !== '') {
    if (login.length < 4)
      newErrorMessage.push("Le login doit faire au minimum 4 caractères");
    else if (login.length > 20)
      newErrorMessage.push("Le login doit faire au maximum 20 caractères");
  }

  if (password !== '') {
    if (password.length < 8)
      newErrorMessage.push("Votre mot de passe doit faire au minimum 8 caractères");
    else if (password.length > 30)
      newErrorMessage.push("Votre mot de passe doit faire au maximum 30 caractères");
    
    // regex modifié légèrement de la classe User car le standard regex diffère en JS
    if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\w\W]{8,30}$/)) 
      newErrorMessage.push("Votre mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre");
  }

  emit('loginError', newErrorMessage);
});
</script>

<template>
  <h3> Login to an existing account</h3>
  <form @submit.prevent="connect" class="content">
    <label for="login-field">Login</label>
    <input id="login-field" type="text" minlength="4" v-model="connectingUser.login" >

    <label for="password-field">Mot de passe</label>
    <!-- regex modifié légèrement de la classe User car le standard regex diffère en HTML -->
    <input id="password-field" minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\w\W]{8,30}" type="password" v-model="connectingUser.password" > 

    <button type="submit"> Connexion</button>
  </form>
</template>

<style scoped>
</style>
