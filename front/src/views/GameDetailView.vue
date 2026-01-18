<script setup lang="ts">
import { ref, type Ref } from 'vue';
import type { Game } from '../types.ts';
import { apiStore } from '@/util/apiStore.ts';
import { useRoute } from 'vue-router';
import CriticList from '@/components/CriticList.vue';
import CriticFormComponent from '@/components/CriticFormComponent.vue';

const route = useRoute();
const props = defineProps<{passedGame?: Ref<Game>}>();

import GameDetailComponent from "@/components/GameDetailComponent.vue";
</script>

<template>
<GameDetailComponent />
</template>

<style scoped>

</style>
