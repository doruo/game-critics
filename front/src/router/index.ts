import { createRouter, createWebHistory, type RouteLocationNormalizedGeneric } from 'vue-router'
import GameListComponent from '@/components/GameListComponent.vue'
import GameDetailView from '@/views/GameDetailView.vue'
import UserDetailView from '@/views/UserDetailView.vue'
import AccountView from '@/views/AccountView.vue'
import UserListView from "@/views/Admin/UserListView.vue";
import AdminManageGamesView from "@/views/Admin/AdminManageGamesView.vue";
import GameFormComponent from "@/components/GameFormComponent.vue";
import GameListView from "@/views/GameListView.vue";
import { loggedInUser } from '@/util/apiStore'
import { addNotif } from '@/util/notifStore'

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
      path: '/game/:id',
      name: 'gameDetail',
      component: GameDetailView,
    },
    {
      // user page
      path: '/user/:id',
      name: 'userDetail',
      component: UserDetailView,
    },
    {
      // logged in user's account page
      path: '/account',
      name: 'account',
      component: AccountView,
      beforeEnter: preventAccessAccountPage,
    },
    {
      // Admin Manage Games page
      path: '/admin/games',
      name: 'manageGames',
      component: AdminManageGamesView,
      beforeEnter: preventAccessAdminPage,
    },
    {
      // users admin page
      path: '/admin/users',
      name: 'usersAdmin',
      component: UserListView,
      beforeEnter: preventAccessAdminPage,
    },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue'),
    // },
    {
      // 404
      path: '/:catchAll(.*)*',
      redirect: '/games',
    },
  ],
})

function preventAccessAdminPage(to: any, from: RouteLocationNormalizedGeneric) {
  if (loggedInUser.value === null || !loggedInUser.value.roles || !loggedInUser.value.roles.includes('ROLE_ADMIN')) {
    addNotif({autoRemoved: true, type: 'warning', message: "Cette page n'est accessible qu'aux administrateurs"});
    return from.fullPath;
  }
}

function preventAccessAccountPage(to: any, from: RouteLocationNormalizedGeneric) {
  if (loggedInUser.value === null) {
    addNotif({autoRemoved: true, type: 'warning', message: "Cette page n'est accessible qu'aux utilisateurs connectés"});
    return from.fullPath;
  }
}


export default router
