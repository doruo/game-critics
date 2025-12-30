export interface Game{
    id: number | string;
    name: string;
    publisher: string;
    averageNote: number;
}

export interface User {
    id: number | string;
    login: string;
    email: string;
}

export interface Critic {
    id: number | string;
    message: string;
    author: User;
    game: Game;
    note: number;
    date: string; // Si si, c'est un type string dans le TD car c'est trop compliqué autrement
}
