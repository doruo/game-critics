<script setup lang="ts">
import { computed, ref, type Ref } from 'vue';
import type { Critic } from '../types.ts';
import { apiStore, loggedInUser } from '@/util/apiStore.ts';

const props = defineProps<{
  critic: Critic,
  displayFor: 'game' | 'user',
}>();

const userIsAuthor: Ref<boolean> = computed(() =>
  loggedInUser.value && loggedInUser.value.login == props.critic.author.login ? true : false
);

const editedCritic = ref({
  message: props.critic.message,
  note: props.critic.note,
})

const isBeingEdited: Ref<boolean> = ref(false);

function deleteCrtic() : void {
  apiStore.deleteResource('critics', props.critic.id as string)
  // TODO : message de succès ou d'erreur et emit pour être suppr de la liste des critiques
}

function saveEditedCritic() : void {
  apiStore.patchResource('critics', props.critic.id as string, editedCritic.value)
  .then(res => {
    if (res.success)
      isBeingEdited.value = false;
    // TODO : message de succès ou d'erreur
  });
}

function cancelEdit() : void {
  isBeingEdited.value = false;
  editedCritic.value.message = props.critic.message;
  editedCritic.value.note = props.critic.note;
}
</script>

<template>
  <div class="user-critic critic" v-if="displayFor === 'user'">
    <hr>

    <button v-if="userIsAuthor && !isBeingEdited" @click="isBeingEdited = true"> Edit Critic</button>
    <button v-if="isBeingEdited" @click="saveEditedCritic"> Save</button>
    <button v-if="isBeingEdited" @click="cancelEdit"> Cancel</button>
    <button v-if="userIsAuthor" @click="deleteCrtic"> Delete Critic</button>

    <p v-if="!isBeingEdited">{{ critic.message }}</p>
    <textarea v-else v-model="editedCritic.message" ></textarea>

    <p><i>Published by </i> <RouterLink :to="`/users/${critic.author.id}`"> {{ critic.author.login }}</RouterLink> at {{ (new Date(critic.date)).toLocaleString("fr") }}</p>

    <p v-if="!isBeingEdited">Note : {{ critic.note }} Stars</p>
    <p v-else>Note : <input v-model="editedCritic.note" type="number"> Stars</p>
  </div>

  <div class="game-critic critic" v-else-if="displayFor === 'game'">
    <hr>
    <button v-if="userIsAuthor && !isBeingEdited" @click="isBeingEdited = true"> Edit Critic</button>
    <button v-if="isBeingEdited" @click="saveEditedCritic"> Save</button>
    <button v-if="isBeingEdited" @click="cancelEdit"> Cancel</button>
    <button v-if="userIsAuthor" @click="deleteCrtic"> Delete Critic</button>

    <p v-if="!isBeingEdited">{{ critic.message }}</p>
    <textarea v-else v-model="editedCritic.message" ></textarea>

    <p><i>For the game : </i> <RouterLink :to="`/games/${critic.game.id}`"> {{ critic.game.name }}</RouterLink> at {{ (new Date(critic.date)).toLocaleString("fr") }}</p>

    <p v-if="!isBeingEdited">Note : {{ critic.note }} Stars</p>
    <p v-else>Note : <input v-model="editedCritic.note" type="number"> Stars</p>
  </div>
</template>

<style scoped>
</style>
