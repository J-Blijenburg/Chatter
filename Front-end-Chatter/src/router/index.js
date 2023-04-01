import { createRouter, createWebHistory } from 'vue-router'

import Main from '../components/Main.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Home from '../components/Home.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', component: Main },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/home', component: Home }
  ]
})

export default router
