<script setup>
import {RouterLink} from "vue-router";
import {useAuthStore} from "../stores/auth.store";
const auth = useAuthStore();

</script>

<template>
    <header class="container mx-auto navbar bg-base-100 shadow rounded-lg mb-6" v-if="auth.user">
        <div class="flex-1">
            <RouterLink :to="{ name: 'Home' }" class="btn btn-ghost normal-case text-xl">Le Bus Magique</RouterLink>
        </div>
        <div class="flex-none gap-2">
            <a  href="#!" @click.prevent="auth.logout()" class="avatar online placeholder">
                <div class="bg-neutral-focus text-neutral-content uppercase text-sm font-semibold rounded-full w-10">
                    <span>THO</span>
                </div>
            </a>
        </div>
    </header>
</template>