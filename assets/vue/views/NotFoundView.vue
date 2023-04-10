<template>
    <div class="flex w-full h-full items-center justify-center gap-4 flex-col">
        <h1 class="text-4xl font-semibold">Erreur 404</h1>
        <p>Page introuvable...</p>
        <RouterLink :to="{ name: 'Home' }" class="btn btn-primary">Retourner à l'accueil</RouterLink>
    </div>
</template>

<style scoped>
.title {
  color: #0000F0;
}
.hero-body {
  background-color: gray;
  padding: 15px;
}

.title {
    color: white;
}
</style>
<script setup>
import {RouterLink} from "vue-router";
</script>