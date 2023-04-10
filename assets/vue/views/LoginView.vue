<script setup>
import {ref} from 'vue';
import router from "../router";

const inputs = ref({
    username: null,
    password: null,
});

const errors = ref({
    username: null,
    password: null,
    form: null,
});

async function submit() {
  let error = false;

  if(!inputs.value.username) {
    errors.value.username = 'L\'adresse e-mail est requise.';
    error = true;
  }

  if(!inputs.value.password) {
      errors.value.password = 'Le mot de passe est requis.';
      error = true;
  }

  if(error) {
      return;
  }

  await fetch('/api/login', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      credentials: 'include',
      body: JSON.stringify(inputs.value)
  }).then(res => {
      if (res.ok) {
          return res.json();
      }
      throw new Error(`${res.statusText} (${res.status})`);
  }).then(async () => {
      inputs.value.username = null;
      inputs.value.password = null;

      await router.push('/admin');
  }).catch(err => {
      inputs.value.password = null;
      errors.value.form = err;
  });
}
</script>

<template>
  <form class="rounded-xl shadow-lg bg-base-100 border p-6 max-w-xl mx-auto flex flex-col gap-4" @submit.prevent="submit">
      <h1 class="text-3xl font-semibold leading-5 mb-2">Connexion</h1>
      <p v-if="errors.form" class="text-red-500">{{errors.form}}</p>
      <input type="email" placeholder="Adresse e-mail" class="input input-bordered" v-model="inputs.username">
      <p v-if="errors.username" class="-mt-2 text-red-500">{{errors.username}}</p>
      <input type="password" placeholder="Mot de passe"  class="input input-bordered" v-model="inputs.password">
      <p v-if="errors.password" class="-mt-2 text-red-500">{{errors.password}}</p>
      <button type="submit" class="btn">Se connecter</button>
  </form>
</template>