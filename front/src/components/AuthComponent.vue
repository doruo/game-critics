<script setup lang="ts">
import { ref, watch, type Ref } from 'vue';
import AuthLoginComponent from './Auth/AuthLoginComponent.vue';
import AuthLogoutComponent from './Auth/AuthLogoutComponent.vue';
import { loggedInUser } from '@/util/apiStore';
import AuthCreateComponent from './Auth/AuthCreateComponent.vue';
import { isAuthDiplayed } from '@/util/authDisplayedStore';
import NavButton from '../components/NavButton.vue';

  const displayedPage: Ref<'login' | 'create-account'> = ref('login');
  const errors: Ref<Array<string> | null> = ref(null);

  watch([displayedPage, isAuthDiplayed, loggedInUser], () => {
    errors.value = null;
  });
</script>

<template>
  <div class="background-auth" @click="isAuthDiplayed = false" v-if="isAuthDiplayed">
    <div class="auth" @click.stop>
  
      <div class="choices" v-if="!loggedInUser">
        <NavButton @click="displayedPage = 'login'">Login</NavButton>
        <NavButton @click="displayedPage = 'create-account'">Create Account</NavButton>
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
    background-color: rgba(0, 0, 0, .1);
    justify-content: center;
    position: fixed;
    min-height: 100%;
    min-width: 100%;
    backdrop-filter: blur(2px);
  }

  .background-auth .auth {
    height: fit-content;
    width: fit-content;
    background-image: linear-gradient(90deg, white 40%, rgb(185, 185, 185) 90% );
    border: 3px solid rgb(0, 204, 255);
    border-radius: 15px;
    padding: .5em;
  }

  .background-auth .auth .choices {
    display: flex;
    gap: 0.5em;
  }
</style>
