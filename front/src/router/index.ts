import { createRouter, createWebHistory } from 'vue-router'
import GameListView from '@/views/GameListView.vue'
import GameDetailView from '@/views/GameDetailView.vue'
import UserDetailView from '@/views/UserDetailView.vue'
import AccountView from '@/views/AccountView.vue'
import AdminView from '@/views/Admin/AdminView.vue'
import UserListView from "@/views/Admin/UserListView.vue";

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
      // invalidated Games page
      path: '/admin/games',
      name: 'createdGames',
      component: GameListView,
      props: {adminMode: true}
    },
    {
      // user page
      path: '/user/:id',
      name: 'userDetail',
      component: UserDetailView,
    },
    {
      // users admin page
      path: '/admin/users',
      name: 'usersAdmin',
      component: UserListView,
    },
    {
      // logged in user's account page
      path: '/account',
      name: 'account',
      component: AccountView,
    },
    {
      //Admin page
      path: '/admin',
      name: 'admin',
      component: AdminView,
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
