import axios from 'axios';

const ApiClient = axios.create({
    baseURL: '/api',
    withCredentials: true,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

export default {
    async postLogin(data = {}) {
        return await ApiClient.post('/login', data);
    },
    async getUser() {
        return await ApiClient.get('/user');
    },
    async getLogout() {
        return await ApiClient.get('logout');
    },
    async getUsers() {
        return await ApiClient.get('/users');
    }
}