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
    <div v-else>
        <h2> {{ game.name }}</h2>
        <p> Published by <b> {{ game.publisher }}</b></p>
        <p> Developed by <b> {{ game.developer }}</b></p>

        <hr>
        <blockquote> {{ game.description }}</blockquote>
        <ul> Playable on :
            <li v-for="platform in game.platform"> {{ platform }}</li>
        </ul>
        <p>Available for {{ game.price }} $</p>

        <div class="additional-info">
            <p>Additional info :</p>
            <ul>
                <li>Genre : {{ game.genre }}</li>
                <li>Gamemode : {{ game.gameMode }}</li>
                <li>Pegi {{ game.targetAge }}</li>
                <li>Licence : {{ game.license ? game.license : 'None' }}</li>
                <li>Released on {{ new Date(game.releaseDate).toLocaleDateString() }}</li>
            </ul>
        </div>
    </div>

    <br>
    <h2> Avis :</h2>
    <CriticList :id-type="('game')" :id="(props.passedGame ? props.passedGame.value.id as string : route.params.id as string)"/>
</template>
