import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/HomeView'
import NotFound from '../views/NotFoundView'
import Login from "../views/LoginView.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/admin',
            name: 'Home',
            component: Home
        },
        {
            path: '/admin/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/admin/:catchAll(.*)',
            name: 'NotFound',
            component: NotFound
        }
    ]
})

export default router