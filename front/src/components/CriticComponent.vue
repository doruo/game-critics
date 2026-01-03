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
  generalMessage: props.critic.generalMessage,
  visualMessage: props.critic.visualMessage,
  soundtrackMessage: props.critic.soundtrackMessage,
  scenarioMessage: props.critic.scenarioMessage,
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

  editedCritic.value.generalMessage = props.critic.generalMessage;
  editedCritic.value.visualMessage = props.critic.visualMessage;
  editedCritic.value.soundtrackMessage = props.critic.soundtrackMessage;
  editedCritic.value.scenarioMessage = props.critic.scenarioMessage;

  editedCritic.value.note = props.critic.note;
}
</script>

<template>
  <div :class="(`${displayFor}-critic critic`)">
    <hr>

    <button v-if="userIsAuthor && !isBeingEdited" @click="isBeingEdited = true"> Edit Critic</button>
    <button v-if="isBeingEdited" @click="saveEditedCritic"> Save</button>
    <button v-if="isBeingEdited" @click="cancelEdit"> Cancel</button>
    <!-- TODO : s'assurer que le role soit bien 'ADMIN' et pas autre chose -->
    <button v-if="userIsAuthor || loggedInUser?.roles.includes('ADMIN')" @click="deleteCrtic"> Delete Critic</button>

    <p><b> General Critic :</b></p>
    <p v-if="!isBeingEdited">{{ critic.generalMessage }}</p>
    <textarea v-else v-model="editedCritic.generalMessage" ></textarea>

    <p><b> Visuals Critic :</b></p>
    <p v-if="!isBeingEdited">{{ critic.visualMessage }}</p>
    <textarea v-else v-model="editedCritic.visualMessage" ></textarea>

    <p><b> Soundtrack's Critic :</b></p>
    <p v-if="!isBeingEdited">{{ critic.soundtrackMessage }}</p>
    <textarea v-else v-model="editedCritic.soundtrackMessage" ></textarea>

    <p><b> Scenario's Critic :</b></p>
    <p v-if="!isBeingEdited">{{ critic.scenarioMessage }}</p>
    <textarea v-else v-model="editedCritic.scenarioMessage" ></textarea>

    <p v-if="displayFor === 'game'"><i>Published by </i> <RouterLink :to="`/user/${critic.author.id}`"> {{ critic.author.login }}</RouterLink> at {{ (new Date(critic.publicationDate)).toLocaleString("fr") }}</p>
    <p v-else><i>For the game : </i> <RouterLink :to="`/game/${critic.game.id}`"> {{ critic.game.name }}</RouterLink> at {{ (new Date(critic.publicationDate)).toLocaleString("fr") }}</p>

    <p v-if="!isBeingEdited">Note : {{ critic.note }} Stars</p>
    <p v-else>Note : <input v-model="editedCritic.note" type="number"> Stars</p>
  </div>
</template>

<style scoped>
</style>
