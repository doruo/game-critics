<script setup lang="ts">
import { ref, watch, type Ref } from 'vue';
import AuthLoginComponent from './Auth/AuthLoginComponent.vue';
import AuthLogoutComponent from './Auth/AuthLogoutComponent.vue';
import { loggedInUser } from '@/util/apiStore';
import AuthCreateComponent from './Auth/AuthCreateComponent.vue';
import { isAuthDiplayed } from '@/util/authDisplayedStore';

  const displayedPage: Ref<'login' | 'create-account'> = ref('login');
  const errors: Ref<Array<string> | null> = ref(null);

  watch([displayedPage, isAuthDiplayed, loggedInUser], () => {
    errors.value = null;
  });
</script>

<template>
  <div class="background-auth" @click="$emit('hideAuth')" v-if="isAuthDiplayed">
    <div class="auth" @click.stop>
  
      <div class="choices" v-if="!loggedInUser">
        <button @click="displayedPage = 'login'">Login</button>
        <button @click="displayedPage = 'create-account'">Create Account</button>
      </div>

      <ul style="color: red;" v-if="errors"> 
        <li v-for="error in errors"> {{ error }}</li>
      </ul>

      <AuthLogoutComponent @logout-error="(messages) => errors = messages" v-if="loggedInUser"/>
      <AuthLoginComponent @login-error="(messages) => errors = messages" v-else-if="displayedPage === 'login'"/>
      <AuthCreateComponent @create-error="(messages) => errors = messages" v-else-if="displayedPage === 'create-account'" />
  
    </div>
  </div>
</template>

<style scoped>
  .background-auth {
    display: flex;
    align-items: center;
    background-color: rgba(0, 0, 0, .3);
    justify-content: center;
    position: fixed;
    min-height: 100%;
    min-width: 100%;
  }

  .background-auth .auth {
    height: fit-content;
    width: fit-content;
    background-color: gray;
    padding: .5em;
  }
</style>
