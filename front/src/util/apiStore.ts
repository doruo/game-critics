export const apiStore = {
    apiUrl: "http://localhost/api/public/", // To change in production

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
        return fetch(this.apiUrl + ressource + '/' + id + '/')
        .then(reponsehttp => reponsehttp.json())
        .then (data => data.member);
    },

    login(login: string, password: string): Promise<unknown> {
        return fetch(this.apiUrl + "api/auth", {
            method: "POST",  
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
            body: JSON.stringify({login: login, password: password}),
        })
    }
    //à compléter plus tard avec les autres appels à l'API
}
