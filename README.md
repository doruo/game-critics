# GameCritics

Site de critiques de jeux vidéos.

Permet aux utilisateurs de consulter des critiques de jeux, noter les jeux et gérer leurs jeux favoris.

Répartition du travail

Hicham : 20%
Marc : 20%
Yann : 30%
Matteo : 30%



---

## Déploiement & Dépôts

### URL des projets déployés
- Front VueJS : [https://webinfo.iutmontp.univ-montp2.fr/~benhalimam/gamecritics/front/dist](https://webinfo.iutmontp.univ-montp2.fr/~benhalimam/gamecritics/front/dist)
- API Platform : [https://webinfo.iutmontp.univ-montp2.fr/~benhalimam/gamecritics/api/public/api/](https://webinfo.iutmontp.univ-montp2.fr/~benhalimam/gamecritics/api/public/api/)

### Dépôts Git
[https://gitlabinfo.iutmontp.univ-montp2.fr/ferhanih-hayem-bodiguely-benhalimam/gamecritics/](https://gitlabinfo.iutmontp.univ-montp2.fr/ferhanih-hayem-bodiguely-benhalimam/gamecritics/)

---

## Installation & Mise en place

### Prérequis
- PHP >= 8.1
- Symfony >= 6.9
- Composer
- Node.js / npm
- Docker & Docker Compose

### Installation des dépendances
```bash
# API
cd ~/gamecritics/api
composer install

# Front
cd ../front
npm install

Déploiement en local
cd ~/gamecritics
docker compose up -d
```

### Base de données

- Créer une base gamecritics dans phpMyAdmin.

- Importer le script SQL fourni à la racine du dépôt api via l’onglet SQL.

#### Peupler la BD

Un script SQL est fourni pour ajouter des utilisateurs, jeux et critiques de test.

Exemple d’utilisateurs :

| Type                | Login | Mot de passe |
| ------------------- | ----- | ------------ |
| Administrateur      | admin | Motdepasse1    |
| Utilisateur basique | user | Motdepasse1     |
| Utilisateur basique | userPDP | Motdepasse1     |

### Présentation du thème

#### Objet critiqué : jeux vidéo.

Informations affichées pour un jeu : nom, description, studio, éditeur, genre, mode de jeu, âge recommandé, plateformes, prix, images, note moyenne.

#### Critiques :

- Note générale (0-20)

- Critique des graphismes

- Critique de la bande-son

- Critique du scénario

Chaque utilisateur peut créer, modifier ou supprimer ses propres critiques.

Les administrateurs peuvent valider les jeux et gérer les utilisateurs.

### Authentification

Authentification via JWT.

#### Routes principales :

- Connexion : /auth → retourne le JWT

- Déconnexion : /token/invalidate

- Refresh token : /token/refresh

Les tokens sont hashés en base de données pour plus de sécurité.

### API - Routes principales

#### Users :
| Route                            | Méthode | Description                          | Sécurité               |
| -------------------------------- | ------- | ------------------------------------ | ---------------------- |
| `/users`                         | GET     | Liste des utilisateurs               | Admin                  |
| `/users/{id}`                    | GET     | Détail d’un utilisateur              | Admin ou user connecté |
| `/users/{id}`                    | PATCH   | Mise à jour utilisateur              | User ou Admin          |
| `/users/{id}`                    | DELETE  | Supprimer un utilisateur             | User ou Admin          |
| `/users/{id}/promoteAdmin`       | PATCH   | Promouvoir un utilisateur en admin   | Admin                  |
| `/users/{id}/favoritesGames`     | GET     | Liste jeux favoris                   | User connecté          |
| `/users/{id}/favoritesGames`     | PATCH   | Modifier jeux favoris                | User connecté          |
| `/users/{id}/critics`            | GET     | Liste critiques d’un utilisateur     | Public                 |
| `/users/{id}/critics`            | POST    | Ajouter critique pour un utilisateur | User connecté          |
| `/users/{id}/critics/{criticId}` | GET     | Détail critique d’un utilisateur     | Public                 |
| `/users/{userId}/critics/{id}`   | PATCH   | Modifier critique                    | Auteur ou Admin        |
| `/users/{userId}/critics/{id}`   | DELETE  | Supprimer critique                   | Auteur ou Admin        |
| `/users/{id}/favoritesCritics`   | GET     | Critiques favorites de l’utilisateur | User connecté          |

#### Games : 
| Route               | Méthode | Description                 | Sécurité                       |
| ------------------- | ------- | --------------------------- | ------------------------------ |
| `/games`            | GET     | Liste tous les jeux validés | Public                         |
| `/games/{id}`       | GET     | Détail d’un jeu             | Public si validé / Admin sinon |
| `/games`            | POST    | Ajouter un jeu              | User connecté                  |
| `/games/{id}`       | PATCH   | Modifier un jeu             | Admin                          |
| `/games/{id}`       | DELETE  | Supprimer un jeu            | Admin                          |
| `/unvalidatedGames` | GET     | Liste des jeux non validés  | Admin                          |


#### Critics:
| Route                      | Méthode | Description                        |
| -------------------------- | ------- | ---------------------------------- |
| `/games/{id}/critics`      | GET     | Liste critiques d’un jeu           |
| `/users/{id}/critics`      | GET     | Liste critiques d’un utilisateur   |
| `/users/{id}/critics/{id}` | GET     | Détail d’une critique              |
| `/users/{id}/critics`      | POST    | Créer critique pour un utilisateur |
| `/users/{id}/critics/{id}` | PATCH   | Modifier critique                  |
| `/users/{id}/critics/{id}` | DELETE  | Supprimer critique                 |
