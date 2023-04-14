import { defineStore } from 'pinia'
import router from "../router";
import ApiService from "../services/ApiService";
import {ref} from "vue";

export const useAuthStore = defineStore('auth', () => {
    const user = ref(JSON.parse(localStorage.getItem('user')));
    const returnUrl = ref(null);
    const error = ref(null);

    async function login(username, password) {
        this.error = null;
        const user = await ApiService.postLogin({ username, password });
        if(user) {
            this.user = await ApiService.getUser().then((res) => {
                if(res.data.roles.indexOf('ROLE_ADMIN') < 0) {
                    this.error = 'Error 401: Unauthorized';
                    return null;
                }
                localStorage.setItem('user', JSON.stringify(res.data));
                return res.data;
            });

        }
        await router.push(returnUrl.value || '/admin');
    }

    async function logout() {
        localStorage.removeItem('user');
        await ApiService.getLogout();
        this.user = null;
        await router.push('/admin/login');
    }

    function setReturnUrl(url) {
        returnUrl.value = url;
    }

    return { user, error, setReturnUrl, login, logout }
})