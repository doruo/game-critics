<script setup lang="ts">
import type {User} from "@/types.ts";
import {type Ref, ref, watch} from "vue";
import {apiStore} from "@/util/apiStore.ts";
import UserComponent from "@/components/UserComponent.vue";
import {useRoute} from "vue-router";
import {user1, user2, user3} from "@/mock.ts";



const users: Ref<User[] | 'loading' | 'failed'> = ref('loading');
const route = useRoute();


const loadUsers = async () => {
  //apiStore.getAll('user').then((data) => { users.value = data as User[];}).catch(() => users.value = 'failed');

  users.value = [user1.value, user2.value, user3.value];
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

  <UserComponent v-for="user in users" :user="user" />
</template>

<style scoped>

</style>
