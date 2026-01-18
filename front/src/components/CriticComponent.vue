<script setup lang="ts">
import { computed, ref, type Ref } from 'vue';
import type { Critic } from '../types.ts';
import { apiStore, loggedInUser } from '@/util/apiStore.ts';
import { addNotif } from '@/util/notifStore.ts';

const props = defineProps<{
  critic: Critic,
  displayFor: 'game' | 'user',
}>();

const emit = defineEmits<{
  removeCritic: [criticToRemove: Critic],
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
  .then((res) => {
    if (res.success) {
      addNotif({autoRemoved: true, type: 'success', message: "The Critic has been deleted"});
      emit('removeCritic', props.critic);
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "The Critic could not be deleted: " + res.error});
    }
  })
}

function saveEditedCritic() : void {
  apiStore.patchResource('critics', props.critic.id as string, editedCritic.value)
  .then(res => {
    if (res.success) {
      isBeingEdited.value = false;
      addNotif({autoRemoved: true, type: 'success', message: "The Critic has been edited"});
    }
    else {
      addNotif({autoRemoved: false, type: 'error', message: "The Critic could not be edited : " + res.error});
    }
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
    <button v-if="userIsAuthor && !isBeingEdited" @click="isBeingEdited = true"> Edit Critic</button>
    <button v-if="isBeingEdited" @click="saveEditedCritic"> Save</button>
    <button v-if="isBeingEdited" @click="cancelEdit"> Cancel</button>
    <button v-if="userIsAuthor || loggedInUser?.roles.includes('ROLE_ADMIN')" @click="deleteCrtic"> Delete Critic</button>

    <p v-if="!isBeingEdited">Note : <b>{{ critic.note }}</b> Stars</p>
    <p v-else>Note : <input v-model="editedCritic.note" type="number"> Stars</p>

  <div class="messages">

    <p><b> General Critic :</b></p>
    <p class="message" v-if="!isBeingEdited">{{ critic.generalMessage }}</p>
    <textarea class="message" v-else v-model="editedCritic.generalMessage" ></textarea>

    <p><b> Visuals Critic :</b></p>
    <p class="message" v-if="!isBeingEdited">{{ critic.visualMessage }}</p>
    <textarea class="message" v-else v-model="editedCritic.visualMessage" ></textarea>

    <p><b> Soundtrack's Critic :</b></p>
    <p class="message" v-if="!isBeingEdited">{{ critic.soundtrackMessage }}</p>
    <textarea class="message" v-else v-model="editedCritic.soundtrackMessage" ></textarea>

    <p><b> Scenario's Critic :</b></p>
    <p class="message" v-if="!isBeingEdited">{{ critic.scenarioMessage }}</p>
    <textarea class="message" v-else v-model="editedCritic.scenarioMessage" ></textarea>
  </div>

    <p v-if="displayFor === 'game'"><i>Published by </i> <RouterLink :to="`/user/${critic.author.id}`"> {{ critic.author.login }}</RouterLink> on {{ (new Date(critic.publicationDate)).toLocaleString("fr") }}</p>
    <p v-else><i>For the game : </i> <RouterLink :to="`/game/${critic.game.id}`"> {{ critic.game.name }}</RouterLink> on {{ (new Date(critic.publicationDate)).toLocaleString("fr") }}</p>

  </div>
  <br>
</template>

<style scoped>
  .critic {
    border-top: 4px solid rgb(0, 204, 255);
    border-bottom: 4px solid rgb(0, 204, 255);
    border-radius: 8px;
    padding: 0.3em;
  }

  .messages {
    border: 2px solid black;
    border-radius: 15px;
    max-width: 100%;
    min-width: 700px;
    padding: 0.5em;
  }

  .messages .message {
    margin-left: 1em;
    background-color: gray;
    color: white;
    padding: 0.3em;
    border-radius: 5px;
  }
  .messages textarea {
    width: 90%;
  }
</style>
