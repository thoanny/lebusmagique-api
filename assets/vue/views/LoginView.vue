<script setup>
import {ref} from 'vue';
import {useAuthStore} from "../stores/auth.store";

const auth = useAuthStore();

const loading = ref(false);
const inputs = ref({
    username: null,
    password: null,
});
const errors = ref({
    username: null,
    password: null,
    form: null,
});

async function onSubmit() {
  const {username, password} = inputs.value;
  const error = ref(false);

  loading.value = true;

  if(!username) {
    errors.value.username = 'L\'adresse e-mail est requise.';
    error.value = true;
  }

  if(!password) {
      errors.value.password = 'Le mot de passe est requis.';
      error.value = true;
  }

  if(error.value) {
      return;
  }

  return auth.login(username, password).then(() => loading.value = false)
      .catch(error => {
          const {code, message} = error.response.data;
          errors.value.form = `Error ${code}: ${message}`;
          loading.value = false;
      });
}

function logout() {
    return auth.logout();
}
</script>

<template>
  <form class="rounded-xl shadow-lg bg-base-100 border p-6 max-w-xl mx-auto flex flex-col gap-4 mt-6" @submit.prevent="onSubmit" v-if="!auth.user">
      <h1 class="text-3xl text-primary font-semibold leading-5 mb-2">Connexion</h1>
      <p v-if="auth.error" class="text-red-500">{{auth.error}}</p>
      <p v-if="errors.form" class="text-red-500">{{errors.form}}</p>
      <input type="email" placeholder="Adresse e-mail" class="input input-bordered" v-model="inputs.username">
      <p v-if="errors.username" class="-mt-2 text-red-500">{{errors.username}}</p>
      <input type="password" placeholder="Mot de passe"  class="input input-bordered" v-model="inputs.password">
      <p v-if="errors.password" class="-mt-2 text-red-500">{{errors.password}}</p>
      <button type="submit" class="btn" :class="{'loading': loading}" v-text="loading?'Merci de patienter...':'Se connecter'" :disabled="loading"></button>
  </form>
  <div v-else>
      <h1 class="text-2xl font-bold mb-4">Bonjour {{auth.user.nickname}}&nbsp;!</h1>
      <button @click="logout" class="btn btn-primary">Déconnexion</button>
  </div>
</template>