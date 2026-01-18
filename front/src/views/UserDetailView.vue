<script setup lang="ts">
import { ref, type Ref } from 'vue';
import type { User } from '../types.ts';
import { apiStore } from '@/util/apiStore.ts';
import { useRoute } from 'vue-router';
import CriticList from '@/components/CriticList.vue';
import {user1} from "@/mock.ts";

  const route = useRoute();

  const user: Ref<User | 'loading' | 'failed'> = ref('loading');
  const numberOfCritics: Ref<number | 'loading'> = ref('loading')

  /*apiStore.getById('users', route.params.id as string)
  .then((data) => user.value = data as User)
  .catch(() => user.value = 'failed'); */
//TODO à remettre

  user.value = user1.value;

</script>

<template>
  <p v-if="user == 'loading'"><i>Fetching User Details</i></p>
  <p v-else-if="user == 'failed'"><i>User Details could not be fetched</i></p>
  <div v-else>
    <h2> Username : {{ user.login }}</h2>
    <p> Games criticized : {{ numberOfCritics }}</p>
  </div>

  <br>
  <h2> Critics :</h2>
  <CriticList @number-of-critics="(number) => numberOfCritics = number" :id-type="('user')" :id="(route.params.id as string)"/>
</template>
