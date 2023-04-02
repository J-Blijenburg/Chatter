import { createRouter, createWebHistory } from 'vue-router'

import Main from '../components/Main.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Start from '../components/Start.vue';
import Profile from '../components/Profile.vue';
import Friends from '../components/Friends.vue';
import AddFriends from '../components/AddFriends.vue';
import Chats from '../components/Chats.vue';


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', component: Main },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/start', component: Start },
    { path: '/friends', component: Friends },
    { path: '/profile', component: Profile },
    { path: '/addfriends', component: AddFriends },
    { path: '/chats', component: Chats },
  ]
})

export default router
