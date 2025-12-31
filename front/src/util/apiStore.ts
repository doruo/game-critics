import type { User } from "@/types";

export const apiStore = {
    apiUrl: "http://localhost/the_feed_api/public/api/", // To change in production

    // Ex : /games to get all the games
    getAll(ressource:string): Promise<unknown> {
        return fetch(this.apiUrl + ressource)
        .then(reponsehttp => reponsehttp.json())
        .then (data => data.member);
    },
    // Ex : /games/5 to get the game of id 5
    getById(ressource: string, id: string|number): Promise<unknown> {
        return fetch(this.apiUrl + ressource + '/' + id)
        .then(reponsehttp => reponsehttp.json())
        .then (data => data.member);
    },
    // Ex : /games/5/critics to get all the critics of the game of id 5
    getAllById(ressource: string, id: string|number, nestedResource: string): Promise<unknown> {
        return fetch(this.apiUrl + ressource + '/' + id + '/' + nestedResource)
        .then(reponsehttp => reponsehttp.json())
        .then (data => data.member);
    },

    login(login: string, password: string): Promise<{ success: boolean, error?: string, user?: User }> {
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
                    return {success: true, user: reponseJSON as User};
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
                return reponsehttp.json()
                .then(() => {
                    return {success: true};
                })
            }
        })
    },
    //à compléter plus tard avec les autres appels à l'API
}
