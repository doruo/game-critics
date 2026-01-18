import { createRouter, createWebHistory } from 'vue-router'
import GameListComponent from '@/components/GameListComponent.vue'
import GameDetailComponent from '@/components/GameDetailComponent.vue'
import UserDetailView from '@/views/UserDetailView.vue'
import AccountView from '@/views/AccountView.vue'
import UserListView from "@/views/Admin/UserListView.vue";
import AdminManageGamesView from "@/views/Admin/AdminManageGamesView.vue";
import GameFormComponent from "@/components/GameFormComponent.vue";
import GameListView from "@/views/GameListView.vue";
import GameDetailView from "@/views/GameDetailView.vue";
import UserFavoritesGamesView from "@/views/UserFavoritesGamesView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
/*
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
*/
    {
      // Game list page
      path: '/games',
      name: 'games',
      component: GameListView,
    },
    {
      // Game page
      path: '/games/:id',
      name: 'gameDetail',
      component: GameDetailView,
    },
    {
      // user page
      path: '/users/:id',
      name: 'userDetail',
      component: UserDetailView,
    },
    {
      // user favorites games page
      path:'/users/:id/favoritesGames',
      name:'userFavoritesGames',
      component: UserFavoritesGamesView,
    },
    {
      // logged in user's account page
      path: '/account',
      name: 'account',
      component: AccountView,
    },
    {
      // Admin Manage Games page
      path: '/admin/games',
      name: 'manageGames',
      component: AdminManageGamesView,
    },
    {
      // users admin page
      path: '/admin/users',
      name: 'usersAdmin',
      component: UserListView,
    },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue'),
    // },
  ],
})

export default router
