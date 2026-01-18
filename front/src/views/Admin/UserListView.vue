<script setup lang="ts">
import type {User} from "@/types.ts";
import {type Ref, ref, watch} from "vue";
import {apiStore} from "@/util/apiStore.ts";
import UserComponent from "@/components/UserComponent.vue";
import {useRoute} from "vue-router";



const users: Ref<User[] | 'loading' | 'failed'> = ref('loading');
const route = useRoute();


const loadUsers = async () => {
  //apiStore.getAll('users').then((data) => { users.value = data as User[];}).catch(() => users.value = 'failed');

  users.value = [
    {
      id: 1,
      login: 'hicham123',
      email: 'hicham@example.com',
      roles: ['ROLE_USER', 'ROLE_ADMIN']
    },
    {
      id: 2,
      login: 'alice456',
      email: 'alice@example.com',
      roles: ['ROLE_USER']
    },
    {
      id: 3,
      login: 'bob789',
      email: 'bob@example.com',
      roles: ['ROLE_USER']
    }
  ];
}

// to reload the list
loadUsers();
watch(() => route.path, () =>{
  loadUsers();
})
</script>

<template>
  <p v-if="users == 'loading'"><i>Fetching users.</i></p>
  <p v-else-if="users == 'failed'"><i>Users could not be loaded</i></p>

  <div class="user-list" v-else>
    <UserComponent v-for="user in users" @load-users="loadUsers" :user="user" />
  </div>
</template>

<style scoped>
  .user-list {
    width: fit-content;;
  }
</style>
