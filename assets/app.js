import { createApp } from 'vue'
import App from './vue/App.vue'
import router from './vue/router'

import './app.css';

const app = createApp(App)
app.use(router)


app.mount('#app')