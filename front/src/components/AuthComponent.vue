<script setup lang="ts">
import { ref, type Ref } from 'vue';
import AuthLoginComponent from './Auth/AuthLoginComponent.vue';
import AuthLogoutComponent from './Auth/AuthLogoutComponent.vue';
import type { User } from '@/types';
  const props = defineProps<{
    isDisplayed: boolean,
    loggedInUser: User | null,
  }>();

  const emits = defineEmits<{
    hideAuth: [],
    changeUser: [user: User | null],
  }>();

  const displayedPage: Ref<'login' | 'create-account'> = ref('login');
  const error: Ref<string | null> = ref(null);
</script>

<template>
  <div class="background-auth" @click="$emit('hideAuth')" v-if="isDisplayed">
    <div class="auth" @click.stop>
  
      <div class="choices" v-if="!loggedInUser">
        <button @click="displayedPage = 'login'">Login</button>
        <button @click="displayedPage = 'create-account'">Create Account</button>
      </div>

      <p style="color: red;" v-if="error"> Error : {{ error }}</p>

      <AuthLogoutComponent @logout-error="(message) => error = message" @logout="$emit('changeUser', null)" v-if="loggedInUser"/>
      <AuthLoginComponent @login-error="(message) => error = message" @login="(user) => $emit('changeUser', user)" v-else-if="displayedPage == 'login'"/>
  
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
