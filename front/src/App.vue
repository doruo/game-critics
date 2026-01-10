<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import AuthComponent from './components/AuthComponent.vue';
import { apiStore, loggedInUser } from './util/apiStore';
import NotifList from './components/NotifList.vue';
import { isAuthDiplayed } from './util/authDisplayedStore';
import NavButton from './components/NavButton.vue';

apiStore.refresh();
</script>

<template>
  <AuthComponent />
  <NotifList />
  <header>
      <nav>
        <NavButton to="/games"> Games</NavButton>
        <NavButton to="/games/0"> Game of id 0</NavButton>
        <NavButton @click="isAuthDiplayed = true"> {{ loggedInUser ? 'Logout' : 'Login' }}</NavButton>
        <span v-if="loggedInUser"> Logged in User: <b>{{ loggedInUser.login }}</b></span>
        <NavButton v-if="loggedInUser" to="/account"> My Account</NavButton>
      </nav>
  </header>

  <RouterView />
</template>

<style scoped>
  nav {
    display: flex;
    gap: 1em;
    background-image: linear-gradient(90deg, white 20%, gray 70% );
    border: 3px solid rgb(0, 204, 255);
    border-radius: 15px;
    padding: 0.5em;
  }

  nav > span {
    padding: 0.5em;
  }

</style>
