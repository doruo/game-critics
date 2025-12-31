<script setup lang="ts">
import { ref, type Ref } from 'vue';
import type { Game } from '../types.ts';
import { apiStore } from '@/util/apiStore.ts';
import GameComponent from '@/components/GameComponent.vue';
import { useRoute } from 'vue-router';
import CriticList from '@/components/CriticList.vue';

const route = useRoute();
const props = defineProps<{passedGame: Ref<Game> | undefined}>();

const game: Ref<Game | 'loading' | 'failed'> = props.passedGame ? props.passedGame : ref('loading');

if (!props.passedGame) {
    apiStore.getById('games', route.params.id as string)
    .then((data) => game.value = data as Game)
    .catch(() => game.value = 'failed');
}
</script>

<template>
    <p v-if="game == 'loading'"><i>Fetching Game Details</i></p>
    <p v-else-if="game == 'failed'"><i>Game Details could not be loaded</i></p>
    <GameComponent :game="game" v-else />

    <br>
    <h2> Avis :</h2>
    <CriticList :id-type="('game')" :id="(props.passedGame ? props.passedGame.value.id as string : route.params.id as string)"/>
</template>
