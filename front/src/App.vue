<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import AuthComponent from './components/AuthComponent.vue';
import { ref } from 'vue';
import { apiStore, loggedInUser } from './util/apiStore';

const displayAuth = ref(false);

apiStore.refresh();
</script>

<template>
  <AuthComponent @hide-auth="displayAuth = false" :is-displayed="displayAuth"/>
  <header>
      <nav>
        <RouterLink to="/">Home</RouterLink>
        <RouterLink to="/games">Games</RouterLink>
        <RouterLink to="/game/0">Game of id 0</RouterLink>
        <button @click="displayAuth = true"> Login</button>
        <span> Logged in User: {{ loggedInUser ? loggedInUser.login : 'User not logged in' }}</span>
      </nav>
  </header>

  <RouterView />
</template>

<style scoped>
/*
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
*/
</style>
