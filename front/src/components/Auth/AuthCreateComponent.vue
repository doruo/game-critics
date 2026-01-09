<script setup lang="ts">
import { ref, watch } from 'vue';
import { apiStore } from '@/util/apiStore';
import { addNotif } from '@/util/notifStore';
import { isAuthDiplayed } from '@/util/authDisplayedStore';

  const newUser = ref({login: '', email: '', plainPassword: ''});
  const emit = defineEmits<{
    createError: [messages: Array<string>],
  }>();

function connect(): void {
  apiStore.createRessource('utilisateurs', newUser.value)
  .then((data) => {
    if (data.success) {
      addNotif({autoRemoved: true, type: 'success', message: "New user of login " + newUser.value.login + " has been created"});
      isAuthDiplayed.value = false;
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "New user could not be created : " + data.error});
      const errorMess = data.error?.split('\n');
      emit('createError', errorMess as Array<string>);
    }
  });
}

watch(newUser.value, () => {
  let newErrorMessage: Array<string> = [];
  const {login, plainPassword} = newUser.value;

  if (login !== '') {
    if (login.length < 4)
      newErrorMessage.push("Le login doit faire au minimum 4 caractères");
    else if (login.length > 20)
      newErrorMessage.push("Le login doit faire au maximum 20 caractères");
  }

  if (plainPassword !== '') {
    if (plainPassword.length < 8)
      newErrorMessage.push("Votre mot de passe doit faire au minimum 8 caractères");
    else if (plainPassword.length > 30)
      newErrorMessage.push("Votre mot de passe doit faire au maximum 30 caractères");
    
    // regex modifié légèrement de la classe User car le standard regex diffère en JS
    if (!plainPassword.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\w\W]{8,30}$/)) 
      newErrorMessage.push("Votre mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre");
  }

  emit('createError', newErrorMessage);
});
</script>

<template>
  <h3> Create an account</h3>
  <form @submit.prevent="connect" class="content">
    <label for="login-field">Login</label>
    <input id="login-field" minlength="4" v-model="newUser.login" >

    <label for="email-field">Email</label>
    <input id="email-field" type="email" v-model="newUser.email" >

    <label for="password-field">Mot de passe</label>
    <input id="password-field" minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\w\W]{8,30}" type="password" v-model="newUser.plainPassword" > 

    <button type="submit"> Create</button>
  </form>
</template>

<style scoped>
</style>
