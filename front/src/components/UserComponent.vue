<script setup lang="ts">
import type {User} from "@/types.ts";
import {apiStore, loggedInUser} from "@/util/apiStore.ts";
import {addNotif} from "@/util/notifStore.ts";
import NavButton from "@/components/NavButton.vue";

const props = defineProps<{
  user: User,
}>();
let isAdmin: boolean | undefined = false;

if (loggedInUser){
  isAdmin = loggedInUser.value?.roles.includes('ROLE_ADMIN')
}

const emit = defineEmits<{loadUsers: []}>();

function deleteUser(user: User) {
    apiStore.deleteResource('users', user.id as string).then((data) => {
      if (data.success) {
        addNotif({autoRemoved: true, type: 'success', message: "The user has been deleted"})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The user have not been deleted"})
      }
    });
    emit("loadUsers");
  }

  function promoteUser(user: User) {
    apiStore.updateResource('users', user.id as string, {roles: ['ROLE_ADMIN']}, 'PATCH').then((data) => {
      if (data.success) {
        addNotif({autoRemoved: true, type: 'success', message: "The user has been promoted."})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The user has not been promoted."})
      }
    });
    emit("loadUsers");
  }

</script>

<template>
  <div :class="{'user-component': true}">
    <b class="id">{{user.id}}</b>
    <RouterLink :to="{name:'userDetail', params: {id: user.id}}">{{user.login}}</RouterLink>
    <span>{{user.email}}</span>

    <NavButton  @click="deleteUser(user)">Delete</NavButton>
    <NavButton  @click="promoteUser(user)">Promote</NavButton>
  </div>
</template>

<style scoped>
  .id {
    color: gold;
  }

.user-component {
  display: flex;
  min-width: fit-content;
  align-items: center;
  width: 100%;
  gap: 0.5em;
  margin: 10px;
  padding: 10px;
  border-radius: 15px;
  border: 3px solid rgb(0, 204, 255);
}

.admin {
  border: 3px solid red;
}

</style>
