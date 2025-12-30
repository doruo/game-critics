# GameCritics

Site de critiques de jeux vidéos.

## Accès principaux

- Front VueJS : http://localhost/front/

- API Platform : http://localhost/api/public/api/

## Dépendances

- php >=8.1 

- symfony >= 6.9

- api-plateform

- doctrine-orm >= 4.2

## Mise en place
http://localhost/api/public/api
```bash
cd ~/gamecritics/api
composer install
cd ..
```

## Deploiment en local

```bash
cd ~/gamecritics
docker compose up -d
```

## API - Routes

### Authentification

#### Route d’authentification

- /auth

#### Invalidation du JWT (déconnexion)

- /token/invalidate 

#### Rafraîchissement du JWT

- /token/refresh 

##

### Utilisateurs

#### Liste des utilisateurs

- /users

#### Détails d’un utilisateur

- /users/{id}

#### Liste des critiques d’un utilisateur

- /users/{id}/critics

##

### Jeux

#### Liste des jeux

- /games

#### Détails d’un jeu

- /games/{id}

#### Liste des jeux favories d’un utilisateur

- /users/{id}/favorites/games

##

### Critiques

#### Liste des critiques d’un utilisateur

- /users/{id}/critics

#### Détails d’une critique d’un utilisateur

- /users/{id}/critics/{id}

#### Liste des critiques d’un jeu

- /games/{id}/critics