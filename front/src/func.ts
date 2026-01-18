import type {Game, User} from "@/types.ts";
import {type Ref, ref} from "vue";
import {apiStore, loggedInUser} from "@/util/apiStore.ts";
import {useRoute} from "vue-router";
import {addNotif} from "@/util/notifStore.ts";

const route = useRoute();
export let alreadyOnFav = ref(false)

let liste: Ref<string[]> = ref([]);

export async function addToFav(game: Game) {
  const id = loggedInUser.value?.id
  if (id) {
    await apiStore.getAllById('users', id as string, 'favoritesGames').then((data) => liste.value = data as string[])
        .catch(() => addNotif({autoRemoved: true, message: "Favorit list cannot be fetched", type: 'error'}));
    liste.value.push('games/' + game.id);
    await apiStore.updateResource('users', id as string, liste.value, 'PUT', 'favoritesGames')
        .catch(() => addNotif({autoRemoved: true, message: "Favorit list cannot be updated", type: 'error'}));
  }
}
export async function delFromFav(game: Game){
  const id = loggedInUser.value?.id
  if (id) {
    await apiStore.getAllById('users', id as string, 'favoritesGames').then((data) => liste.value = data as string[])
        .catch(() => addNotif({autoRemoved: true, message: "Favorit list cannot be fetched", type: 'error'}));
    liste.value.filter(IRI => IRI !== 'games/' + game.id);
    await apiStore.updateResource('users', id as string, liste.value, 'PUT', 'favoritesGames')
        .catch(() => addNotif({autoRemoved: true, message: "Favorit list cannot be updated", type: 'error'}));
  }
}
export async function testingFavGame(game: Game) {
  const id = loggedInUser.value?.id
  if (id) {
    await apiStore.getAllById('users', id as string, 'favoritesGames').then((data) => liste.value = data as string[])
        .catch(() => addNotif({autoRemoved: true, message: "Favorit list cannot be fetched", type: 'error'}));

    alreadyOnFav.value = liste.value.includes('games/' + game.id);
  }
}
