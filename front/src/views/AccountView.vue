<script setup lang="ts">
import { ref, watch } from 'vue';
import { apiStore, loggedInUser } from '@/util/apiStore.ts';

  const newUser = ref({
    login: loggedInUser.value?.login,
    email: loggedInUser.value?.email,
    plainPassword: '',
  });

  watch(loggedInUser, () => {
    newUser.value.login = loggedInUser.value?.login;
    newUser.value.email = loggedInUser.value?.email;
  })

  const confirmDelete = ref(false);

  function saveNewUserInfos() : void {
    const data = {
      login: !newUser.value.login || newUser.value.login === loggedInUser.value?.login ? undefined : newUser.value.login,
      email: !newUser.value.email || newUser.value.email === loggedInUser.value?.email ? undefined : newUser.value.email,
      plainPassword: !newUser.value.plainPassword ? undefined : newUser.value.plainPassword,
    };

    apiStore.patchResource('users', loggedInUser.value?.id as string, data);
    // TODO: Message d'erreur et de succés
  }

  function deleteAccount() {
    apiStore.deleteResource('users', loggedInUser.value?.id as string)
    .then((res) => {
      if (res.success)
        apiStore.logout();
    });
    // TODO: Message d'erreur et de succés
  }
</script>

<template>
  <h2> My Account</h2>
  <form @submit.prevent="saveNewUserInfos">
    <p> Login: <input v-model="newUser.login" type="text"></p>
    <p> Email: <input v-model="newUser.email" type="text"></p>
    <p> New Password: <input v-model="newUser.plainPassword" type="password"></p>

    <button type="submit">Save</button>
  </form>

  <button v-if="!confirmDelete" @click="confirmDelete = true"> Delete Account</button>
  <button v-if="confirmDelete" @click="confirmDelete = false"> No, do NOT Delete My Account.</button>
  <button v-if="confirmDelete" @click="deleteAccount"> Yes, Delete My Account.</button>
</template>