<script setup lang="ts">
import { ref, type Ref } from 'vue';
import AuthLoginComponent from './Auth/AuthLoginComponent.vue';
import AuthLogoutComponent from './Auth/AuthLogoutComponent.vue';
import { loggedInUser } from '@/util/apiStore';
import AuthCreateComponent from './Auth/AuthCreateComponent.vue';
  const props = defineProps<{
    isDisplayed: boolean,
  }>();

  const emits = defineEmits<{
    hideAuth: [],
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

      <AuthLogoutComponent @logout-error="(message) => error = message" v-if="loggedInUser"/>
      <AuthLoginComponent @login-error="(message) => error = message" v-else-if="displayedPage === 'login'"/>
      <AuthCreateComponent @create-error="(message) => error = message" v-else-if="displayedPage === 'create-account'" />
  
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
