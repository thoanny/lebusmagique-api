<script setup>
import { RouterView } from 'vue-router';
import {useAuthStore} from "./stores/auth.store";

import Header from './components/Header.vue';
import Menu from './components/Menu.vue';
import Footer from './components/Footer.vue';

const auth = useAuthStore();

</script>

<template>
    <Header />
    <div class="container mx-auto mb-6 gap-6 flex">
        <Menu v-if="auth.user" />
        <div class="flex-1">
            <RouterView />
        </div>
    </div>
    <Footer />
</template>