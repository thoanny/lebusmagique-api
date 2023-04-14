import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/HomeView'
import NotFound from '../views/NotFoundView'
import Login from "../views/LoginView.vue";
import {useAuthStore} from "../stores/auth.store";

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
            path: '/admin/users',
            name: 'Users',
            children: [
                {
                    path: '',
                    name: 'UsersHome',
                    component: () => import('../views/Users/HomeView.vue')
                }
            ]
        },
        {
            path: '/admin/:catchAll(.*)',
            name: 'NotFound',
            component: NotFound
        }
    ]
});

router.beforeEach(async (to) => {
    const publicPages = ['/admin/login'];
    const authRequired = !publicPages.includes(to.path);
    const auth = useAuthStore();

    if (authRequired && !auth.user) {
        auth.setReturnUrl(to.fullPath);
        return '/admin/login';
    }
});

export default router
