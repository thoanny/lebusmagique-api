<script setup>
import {RouterLink} from "vue-router";
import {onMounted, ref} from "vue";

const user = ref(null);

async function getUser() {
    await fetch('/api/user').then(res => {
        if (res.ok) {
            return res.json();
        }
        throw new Error(`${res.statusText} (${res.status})`);
    }).then(data => {
        user.value = data;
    }).catch(err => {
        console.error(err)
    });
}

onMounted(() => {
    getUser();
});
</script>

<template>
    <header class="container mx-auto navbar bg-base-100 shadow rounded-lg mb-6">
        <div class="flex-1">
            <RouterLink :to="{ name: 'Home' }" class="btn btn-ghost normal-case text-xl">Le Bus Magique</RouterLink>
        </div>
        <div class="flex-none gap-2">
            <RouterLink :to="{ name: 'Home' }" class="avatar online placeholder" v-if="user">
                <div class="bg-neutral-focus text-neutral-content uppercase font-semibold rounded-full w-10">
                    <span>T</span>
                </div>
            </RouterLink>
            <RouterLink :to="{ name: 'Login' }" class="btn btn-primary" v-else>
                Connexion
            </RouterLink>
        </div>
    </header>
</template>