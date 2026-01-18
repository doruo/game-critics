import {ref} from "vue";
import type {Game, User} from "@/types.ts";

export const brawlstars = ref<Game>({
  approved: true,
  averageNote: 4.3,
  description: 'Big game',
  developper: 'Supercell',
  gameMode: 'Singleplayer',
  genre: 'Adventure',
  id: 1,
  images: [
    'https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg',
    'https://www.androidpolice.com/wp-content/uploads/2018/06/unnamed-1-7.png',
    'https://image.winudf.com/v2/image1/Y29tLnN1cGVyY2VsbC5icmF3bHN0YXJzX3NjcmVlbl8xM18xNTY3MTg5NzczXzA4NA/screen-13.jpg?fakeurl=1&type=.jpg'
  ],
  license: "Assassin's creed",
  name: 'Brawl Stars',
  platform: ['Linux', 'Android'],
  pochette: 'https://supercell.com/_next/static/media/games_thumbnail_brawlstars.5cd76330.jpg',
  price: 0,
  publisher: 'Matteo',
  releaseDate: '2021-09-15',
  targetAge: 7,
});

export const minecraft = ref<Game>({
  approved: true,
  averageNote: 4.7,
  description: 'Sandbox building game',
  developper: 'Mojang Studios',
  gameMode: 'Singleplayer / Multiplayer',
  genre: 'Sandbox',
  id: 2,
  images: [
    'https://upload.wikimedia.org/wikipedia/en/5/51/Minecraft_cover.png',
    'https://www.minecraft.net/content/dam/minecraft/pmp/minecraft-main.jpg',
  ],
  license: 'Minecraft',
  name: 'Minecraft',
  platform: ['Windows', 'Linux', 'Mac', 'Android', 'iOS', 'Xbox', 'PlayStation'],
  pochette: 'https://upload.wikimedia.org/wikipedia/en/5/51/Minecraft_cover.png',
  price: 26.95,
  publisher: 'Mojang Studios',
  releaseDate: '2011-11-18',
  targetAge: 7,
});

export const valorant = ref<Game>({
  approved: false,
  averageNote: 4.5,
  description: 'Tactical shooter game',
  developper: 'Riot Games',
  gameMode: 'Multiplayer',
  genre: 'FPS',
  id: 3,
  images: [
    'https://upload.wikimedia.org/wikipedia/en/e/e0/Valorant_cover_art.jpg',
    'https://media.contentapi.ea.com/content/dam/ea/valorant/images/2020/06/valorant-key-art-hero-1920x1080.jpg',
  ],
  license: 'Valorant',
  name: 'Valorant',
  platform: ['Windows', 'Linux', 'IOS'],
  pochette: 'https://upload.wikimedia.org/wikipedia/en/e/e0/Valorant_cover_art.jpg',
  price: 0,
  publisher: 'Riot Games',
  releaseDate: '2020-06-02',
  targetAge: 16,
});
export const user1 = ref<User>({
  id: 1,
  login: 'hicham123',
  email: 'hicham@example.com',
  roles: ['ROLE_USER', 'ROLE_ADMIN'],
});
export const user2 = ref<User>({
  id: 2,
  login: 'alice456',
  email: 'alice@example.com',
  roles: ['ROLE_USER']
});
export const user3 = ref<User>({
  id: 3,
  login: 'bob789',
  email: 'bob@example.com',
  roles: ['ROLE_USER']
});


