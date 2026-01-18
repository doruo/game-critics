<script setup lang="ts">
import type {User} from "@/types.ts";
import {type Ref, ref} from "vue";
import {apiStore} from "@/util/apiStore.ts";
import {addNotif} from "@/util/notifStore.ts";

const props = defineProps<{
  user: User,
}>();

const isAdmin = props.user.roles.includes('ROLE_ADMIN')

const emit = defineEmits<{loadUsers: void}>();

function deleteUser(user: User) {
    apiStore.deleteResource('users', user.login).then((data) => {
      if (data.success) {
        addNotif({autoRemoved: true, type: 'success', message: "The user has been deleted"})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The user have not been deleted"})
      }
    });
    emit("loadUsers");
  }

  function promoteUser(user: User) {
    apiStore.updateResource('games', user.login, {roles: ['ROLE_USER', 'ROLE_ADMIN']}, 'PATCH').then((data) => {
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
  <div :class="{'user-component': true, admin: isAdmin}">
    <b class="id">#{{user.id}}</b>
    <RouterLink :to="{name:'userDetail', params: {id: user.id}}">{{user.login}}</RouterLink>
    <span>{{user.email}}</span>
    <b v-if="isAdmin">(Admin)</b>

    <NavButton v-if="!isAdmin" @click="deleteUser(user)">Delete</NavButton>
    <NavButton v-if="!isAdmin" @click="promoteUser(user)">Promote</NavButton>
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
