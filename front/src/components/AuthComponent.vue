<script setup lang="ts">
import { ref, type Ref } from 'vue';
import AuthLoginComponent from './Auth/AuthLoginComponent.vue';
import AuthLogoutComponent from './Auth/AuthLogoutComponent.vue';
  const props = defineProps<{
    isDisplayed: boolean,
    isLoggedIn: boolean,
  }>();

  const emits = defineEmits<{hideAuth: []}>();

  const displayedPage: Ref<'login' | 'create-account'> = ref('login');
</script>

<template>
  <div class="background-auth" @click="$emit('hideAuth')" v-if="isDisplayed">
    <div class="auth" @click.stop>
  
      <div class="choices" v-if="isLoggedIn">
        <button @click="displayedPage = 'login'">Login</button>
        <button @click="displayedPage = 'create-account'">Create Account</button>
      </div>

      <AuthLogoutComponent v-if="!isLoggedIn"/>
      <AuthLoginComponent v-else-if="displayedPage == 'login'"/>
  
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
