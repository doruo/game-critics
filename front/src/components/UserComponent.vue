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

const editedUser = ref({
  id: props.user.id,
  login: props.user.login,
  email: props.user.email,
  roles: ['ROLE_USER', 'ROLE_ADMIN']
});

function manageUser(user: User, type: 'delete' | 'promote') {
  if (type == "delete") {
    apiStore.deleteResource('user', user.login).then((data) => {
      if (data.success) {
        addNotif({autoRemoved: true, type: 'success', message: "The user has been deleted"})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The user have not been deleted"})
      }
    });
    emit("loadUsers");
  }

  if (type == "promote") {
    apiStore.patchResource('game', user.login, editedUser.value).then((data) => {
      if (data.success) {
        addNotif({autoRemoved: true, type: 'success', message: "The user has been promoted."})
      } else {
        addNotif({autoRemoved: true, type: 'error', message: "The user has not been promoted."})
      }
    });
    emit("loadUsers");
  }
}
</script>

<template>
  <div :class="{'user-component': true, admin: isAdmin}">
    <h2>{{user.login}}</h2>
    <h2>{{user.id}}</h2>
    <a>{{user.email}}</a>
    <a>{{user.roles}}</a>

    <div v-if="!isAdmin" >
      <button @click="manageUser(user, 'delete')">Delete</button>
      <button @click="manageUser(user, 'promote')">Promote</button>
    </div>
  </div>
</template>

<style scoped>

.user-component {
  width: 400px;
  border-width: 3px;
  margin: 10px;
  padding: 10px;
  border-style: solid;     /* sinon la bordure ne s’affiche pas */
  border-color: black;
}

.admin {
  background-color: red;
}

</style>
