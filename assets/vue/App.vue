<script setup>
import { RouterView } from 'vue-router';

import Header from './components/Header.vue';
import Menu from './components/Menu.vue';
import Footer from './components/Footer.vue';
</script>

<template>
    <Header />
    <div class="container mx-auto mb-6 gap-6 flex">
        <Menu />
        <div class="flex-1">
            <RouterView />
        </div>
    </div>
    <Footer />
</template>