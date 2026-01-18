import type { User } from "@/types";
import { ref, watch, type Ref } from "vue";

export const adminNavIsExpanded: Ref<boolean> = ref(false);

export const loggedInUser: Ref<User | null> = ref(null);
export const loggedInUserFavGameIds: Ref<Array<string> | null> = ref(null)

watch(loggedInUser, fetchFavorites)

export async function fetchFavorites() {
    if (loggedInUser.value === null)
        loggedInUserFavGameIds.value = null;
    else {
        await apiStore.getAllById('users', loggedInUser.value.id as string, 'favoritesGames')
        .then((data) => loggedInUserFavGameIds.value = (data as Array<string>) // IRIs
            .map(IRI => IRI.split('/').pop() as string)
        );
        return;
    }
}

export const apiStore = {
    apiUrl: "http://localhost/api/public/api/", // To change in production

    // Ex : /games to get all the games
    getAll(ressource:string): Promise<unknown> {
        return fetch(this.apiUrl + ressource, {
            method: "GET",
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
        })
        .then(reponsehttp => reponsehttp.json())
        .then (data => data.member);
    },
    // Ex : /games/5 to get the game of id 5
    getById(ressource: string, id: string|number): Promise<unknown> {
        return fetch(this.apiUrl + ressource + '/' + id, {
            method: "GET",
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
        })
        .then(reponsehttp => reponsehttp.json())
        .then (data => data);
    },
    // Ex : /games/5/critics to get all the critics of the game of id 5
    getAllById(ressource: string, id: string|number, nestedResource: string): Promise<unknown> {
        return fetch(this.apiUrl + ressource + '/' + id + '/' + nestedResource)
        .then(reponsehttp => reponsehttp.json())
        .then (data => data.member);
    },

    login(login: string, password: string): Promise<{ success: boolean, error?: string }> {
        return fetch(this.apiUrl + "auth", {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
            body: JSON.stringify({login: login, password: password}),
        })
        .then(reponsehttp => {
            if (!reponsehttp.ok) {
                return reponsehttp.json()
                .then(reponseJSON => {
                    return {success: false, error: reponseJSON.message};
                })
            } else {
                return reponsehttp.json()
                .then(reponseJSON => {
                    loggedInUser.value = reponseJSON as User;
                    return {success: true};
                })
            }
        })
    },

    logout(): Promise<{ success: boolean, error?: string }> {
        return fetch(this.apiUrl + "token/invalidate", {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
        })
        .then(reponsehttp => {
            if (!reponsehttp.ok) {
                return reponsehttp.json()
                .then(reponseJSON => {
                    return {success: false, error: reponseJSON.message};
                })
            } else {
                loggedInUser.value = null;
                return {success: true};
            }
        })
    },

    refresh(): Promise<{ success: boolean, error?: string }> {
        return fetch(this.apiUrl + "token/refresh", {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
        })
        .then(reponsehttp => {
            if (!reponsehttp.ok) {
                return reponsehttp.json()
                .then(reponseJSON => {
                    return {success: false, error: reponseJSON.message};
                })
            } else {
                return reponsehttp.json()
                .then(reponseJSON => {
                    loggedInUser.value = reponseJSON as User;
                    return {success: true};
                })
            }
        })
    },

    createRessource(resource: string, data: unknown, refreshAllowed = true): Promise<{ success: boolean, error?: string }> {
        return fetch(this.apiUrl + resource, {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
            body: JSON.stringify(data),
        })
        .then(reponsehttp => {
            if (reponsehttp.ok) {
                return reponsehttp.json()
                .then(() => {
                    return {success: true};
                });
            } else if (reponsehttp.status == 401 && refreshAllowed) {
                return this.refresh()
                .then(refresh => {
                    if (refresh.success)
                        return this.createRessource(resource, data, false);
                    else
                        return {success: false, error: 'unauthorized, failure to refresh token.'}
                });
            } else {
                return reponsehttp.json()
                .then(reponseJSON => {
                    return {success: false, error: reponseJSON.detail};
                });
            }
        })
    },

    deleteResource(resource: string, id: string): Promise<{ success: boolean, error?: string }> {
        return fetch(this.apiUrl + resource + '/' + id, {
            method: "DELETE",
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
        })
        .then(reponsehttp => {
            if (reponsehttp.ok) {
                return {success: true};
            }
            else {
                return reponsehttp.json()
                .then(reponseJSON => {
                    return {success: false, error: reponseJSON.message};
                });
            }
        })
    },

  //par exemple /users/:id/favoritesGames en PUT
    updateResource(resource: string, id: string, data: unknown, method: 'PATCH' | 'PUT', nestedResource?: string): Promise<{ success: boolean, error?: string }> {
      let url = this.apiUrl + resource + '/' + id;
      if (nestedResource){
        url = url + '/' + nestedResource;
      }
        return fetch(url, {
            method: method,
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
            body: JSON.stringify(data),
        })
        .then(reponsehttp => {
            if (reponsehttp.ok) {
                return reponsehttp.json()
                .then(() => {
                    return {success: true};
                });
            }
            else {
                return reponsehttp.json()
                .then(reponseJSON => {
                    return {success: false, error: reponseJSON.message};
                });
            }
        })
    },
    //à compléter plus tard avec les autres appels à l'API
};
