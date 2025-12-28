export const apiStore = {
    apiUrl: "http://localhost/api/public/", // To change in production

    getAll(ressource:string): Promise<unknown> {
        return fetch(this.apiUrl + ressource)
        .then(reponsehttp => reponsehttp.json())
        .then (data => data.member);
    },
    //à compléter plus tard avec les autres appels à l'API
}
