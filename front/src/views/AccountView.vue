<script setup lang="ts">
import { ref, watch, type Ref } from 'vue';
import { apiStore, loggedInUser } from '@/util/apiStore.ts';
import { addNotif } from '@/util/notifStore';
import GameListComponent from '@/components/GameListComponent.vue';
import router from '@/router';

  const errors: Ref<Array<string>> = ref([]);

  const newUser = ref({
    login: loggedInUser.value?.login,
    email: loggedInUser.value?.email,
    plainPassword: '',
  });

  watch(loggedInUser, () => {
    newUser.value.login = loggedInUser.value?.login;
    newUser.value.email = loggedInUser.value?.email;
  })

  watch(newUser.value, () => {
    let newErrorMessages: Array<string> = [];
    const {login, plainPassword} = newUser.value;

    if (login && login !== '') {
      if (login.length < 4)
        newErrorMessages.push("Le login doit faire au minimum 4 caractères");
      else if (login.length > 20)
        newErrorMessages.push("Le login doit faire au maximum 20 caractères");
    }

    if (plainPassword !== '') {
      if (plainPassword.length < 8)
        newErrorMessages.push("Votre mot de passe doit faire au minimum 8 caractères");
      else if (plainPassword.length > 30)
        newErrorMessages.push("Votre mot de passe doit faire au maximum 30 caractères");
      
      // regex modifié légèrement de la classe User car le standard regex diffère en JS
      if (!plainPassword.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\w\W]{8,30}$/)) 
        newErrorMessages.push("Votre mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre");
    }

    errors.value = newErrorMessages
  });

  const confirmDelete = ref(false);

  function saveNewUserInfos() : void {
    const data = {
      login: !newUser.value.login || newUser.value.login === loggedInUser.value?.login ? undefined : newUser.value.login,
      email: !newUser.value.email || newUser.value.email === loggedInUser.value?.email ? undefined : newUser.value.email,
      plainPassword: !newUser.value.plainPassword ? undefined : newUser.value.plainPassword,
    };

    apiStore.updateResource('users', loggedInUser.value?.id as string, data, 'PATCH')
    .then((data) => {
      if (data.success)
        addNotif({autoRemoved: true, type: 'success', message: "The changes have been applied"});
      else
        addNotif({autoRemoved: false, type: 'error', message: "The changes could not be applied : " + data.error});
    });
  }

  function deleteAccount() {
    apiStore.deleteResource('users', loggedInUser.value?.id as string)
    .then((res) => {
      console.log(res);
      
      if (res.success) {
        addNotif({autoRemoved: true, type: 'success', message: "Your account has successfully been deleted, logging you out"});
        // ABSOLUMENT - PAS - SÛR
        document.cookie = `BEARER=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; Secure;`;
        document.cookie = `refresh_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; Secure;`;
        loggedInUser.value = null;
        addNotif({autoRemoved: false, type: 'warning', message: "Si vous avez des difficulté à créer un compte après la suppression d'un compte, tentez de manuellement supprimer les cookies"});
        router.push('/games');
        // apiStore.logout();
      }
      else
        addNotif({autoRemoved: false, type: 'error', message: "Your account could not be deleted : " + res.error});
    });
  }
</script>

<template>
  <h2> My Account</h2>

  <ul style="color: red;" v-if="errors"> 
    <li v-for="error in errors"> {{ error }}</li>
  </ul>

  <form @submit.prevent="saveNewUserInfos">
    <p> <span>Login:</span> <b>{{ loggedInUser?.login }}</b></p>
    <p> <label for="email-field">Email:</label> <input id="email-field" v-model="newUser.email" type="email"></p>
    <p> <label for="password-field">New Password:</label> <input id="password-field" minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\w\W]{8,30}" v-model="newUser.plainPassword" type="password"></p>

    <button type="submit">Save</button>

    <button type="button" v-if="!confirmDelete" @click="confirmDelete = true"> Delete Account</button>
    <button type="button" v-if="confirmDelete" @click="confirmDelete = false"> No, do NOT Delete My Account.</button>
    <button type="button" v-if="confirmDelete" @click="deleteAccount"> Yes, Delete My Account.</button>
  </form>

  <hr>
  <div class="fav-list-container">
    <div class="fav-list">
      <h2> Favorite Games :</h2>
      <GameListComponent :fav-type="true"></GameListComponent>
    </div>
  </div>

</template>

<style scoped>
  form {
    background-image: linear-gradient(90deg, white 70%, #d3d3d3 90% );
    border: 3px solid rgb(0, 204, 255);
    border-radius: 15px;
    padding: .5em;
    width: fit-content;
  }

  .fav-list-container {
    display: flex;
    min-width: 90%;
    justify-content: center;
  }
  .fav-list {
    width: 90%;
  }
</style>