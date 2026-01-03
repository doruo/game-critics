export interface Game{
    id: number | string;
    name: string;
    publisher: string;
    description: string;
    releaseDate: string;
    developer: string;
    averageNote: number;
    gameMode: string;
    targetAge: number;
    genre: string;
    license: string | undefined;
    price: number;
    platform: Array<string>;
    images: Array<string>;
    pochette: string;
    approved: boolean;
}

export interface User {
    id: number | string;
    login: string;
    email: string;
    roles: Array<string>;
}

export interface Critic {
    id: number | string;
    generalMessage: string;
    visualMessage: string;
    soundtrackMessage: string;
    scenarioMessage: string;
    author: User;
    game: Game;
    note: number;
    publicationDate: string;
}
