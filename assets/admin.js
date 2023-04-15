import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './vue/App.vue';
import router from './vue/router';

import './admin.css';

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.use(router);

app.mount('#app');