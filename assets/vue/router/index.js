import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/HomeView'
import NotFound from '../views/NotFoundView'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/admin',
            name: 'Home',
            component: Home
        },
        {
            path: '/admin/:catchAll(.*)',
            name: 'NotFound',
            component: NotFound
        }
    ]
})

export default router