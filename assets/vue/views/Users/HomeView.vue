<script setup>
import ApiService from "../../services/ApiService";
import {onMounted, ref} from "vue";
const users = ref();

onMounted(async () => {
    await ApiService.getUsers().then(res => users.value = res.data);
});

function formatDate(date) {
    return (date) ? new Date(Date.parse(date.date)).toLocaleDateString('FR-fr', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    }) : '&times;';
}
</script>

<template>
  <h1 class="text-3xl font-semibold mb-4">Utilisateurs</h1>
  <table v-if="users" class="table rounded-lg shadow w-full">
      <thead>
        <tr>
            <th>#</th>
            <th>Pseudonyme</th>
            <th class="text-center">Rôle</th>
            <th class="text-center">Création</th>
            <th class="text-center">Connexion</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users">
            <td>{{user.id}}</td>
            <td class="font-bold">{{user.nickname}}</td>
            <td class="text-center">{{user.roles.indexOf('ROLE_ADMIN')>=0?'Administrateur':'Utilisateur'}}</td>
            <td class="text-center" v-html="formatDate(user.createdAt)"></td>
            <td class="text-center" v-html="formatDate(user.lastLoginAt)"></td>
        </tr>
      </tbody>
  </table>
  <div v-else>
      <button class="btn btn-ghost loading">Chargement en cours...</button>
  </div>
</template>