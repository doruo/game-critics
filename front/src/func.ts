import type {Game } from "@/types.ts";
import {type Ref, ref} from "vue";
import {apiStore, fetchFavorites, loggedInUser, loggedInUserFavGameIds} from "@/util/apiStore.ts";
import {useRoute} from "vue-router";
import {addNotif} from "@/util/notifStore.ts";

const route = useRoute();
export const alreadyOnFav = ref(false)


export async function addToFav(game: Game) {
  if (loggedInUser.value === null) {
    addNotif({autoRemoved: true, type: 'error', message: 'Only logged in users can add games to their favorites'})
    return;
  }
  const id = loggedInUser.value.id

  if (loggedInUserFavGameIds.value === null)
    await fetchFavorites();

  if (loggedInUserFavGameIds.value === null) {
    addNotif({autoRemoved: true, message: "Favorite list cannot be fetched", type: 'error'});
    return;
  }
  loggedInUserFavGameIds.value.push(game.id as string);
  await apiStore.updateResource('users', id as string, {favoritesGames: loggedInUserFavGameIds.value.map((currentGame) => favGameIdToIri(currentGame))}, 'PATCH', 'favoritesGames')
        .catch(() => addNotif({autoRemoved: true, message: "Game could not be added to your favorites", type: 'error'}));
}

export async function delFromFav(game: Game){
  if (loggedInUser.value === null) {
    addNotif({autoRemoved: true, type: 'error', message: 'Only logged in users can remove games from their favorites'})
    return;
  }
  const id = loggedInUser.value.id

  if (loggedInUserFavGameIds.value === null)
    await fetchFavorites();

  if (loggedInUserFavGameIds.value === null) {
    addNotif({autoRemoved: true, message: "Favorite list cannot be fetched", type: 'error'});
    return;
  }

  loggedInUserFavGameIds.value = loggedInUserFavGameIds.value
  .filter((currentGame) => currentGame !== game.id as string);
  
  await apiStore.updateResource('users', id as string, {favoritesGames: loggedInUserFavGameIds.value.map((currentGame) => favGameIdToIri(currentGame))}, 'PATCH', 'favoritesGames')
      .catch(() => addNotif({autoRemoved: true, message: "Game could not be removed from your favorites", type: 'error'}));
}

function favGameIdToIri(id: string | number): string {
  return 'api/public/api/games/' + id;
}
