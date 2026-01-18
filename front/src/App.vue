<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import AuthComponent from './components/AuthComponent.vue';
import { apiStore, loggedInUser } from './util/apiStore';
import NotifList from './components/NotifList.vue';
import { isAuthDiplayed } from './util/authDisplayedStore';

apiStore.refresh();

//TODO ajouter v-if="loggedInUser?.roles.includes('ROLE_ADMIN') au div admin
</script>

<template>
  <AuthComponent />
  <NotifList />
  <header>
    <nav>
      <RouterLink to="/">Home</RouterLink>
      <RouterLink to="/games">Games</RouterLink>
      <RouterLink to="/games/0">Game of id 0</RouterLink>
      <RouterLink to="/users/1/favoritesGames">favorites games of id 1</RouterLink>

      <div class="admin-dropdown">
        <RouterLink to="/">Admin</RouterLink>
        <div class="dropdown-content">
          <RouterLink to="/admin/users/">Users</RouterLink>
          <RouterLink to="/admin/games/">Manage games</RouterLink>
        </div>
      </div>

      <button @click="isAuthDiplayed = true"> Login</button>
      <span> Logged in User: {{ loggedInUser ? loggedInUser.login : 'User not logged in' }}</span>
      <RouterLink v-if="loggedInUser" to="/account"> My Account</RouterLink>
    </nav>
  </header>

  <RouterView />
</template>

<style scoped>

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

.admin-dropdown {
  display: inline-block;
  position: relative;
}

.dropdown-content {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background-color: white;
  min-width: 150px;
  box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  display: block;
  padding: 0.5rem 1rem;
  text-decoration: none;
  color: var(--color-text);
}

.dropdown-content a:hover {
  background-color: var(--color-border);
}

.admin-dropdown:hover .dropdown-content {
  display: block;
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

</style>
