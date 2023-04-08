<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
    <header>
        <nav>
            <RouterLink :to="{ name: 'Home' }">Accueil</RouterLink>
        </nav>
    </header>

    <div>
        <RouterView />
    </div>

</template>

<style scoped>
</style>