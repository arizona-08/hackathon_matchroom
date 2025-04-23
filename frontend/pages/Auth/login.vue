<script setup>

import { login } from '~/lib/auth';
import { logout } from '~/lib/auth';
const credentials = reactive({
    email: '',
    password: ''
});

async function handleSubmit() {
    const response = await login(credentials);
    if (response.status === 200) {
        // Handle successful login
        console.log('login successful');
    } else {
        // Handle error
        console.error('login failed', response);
    }
}

async function handleLogout(){
    const response = await logout();
    if (response.status === 200) {
        // Handle successful logout
        console.log('logout successful');
    } else {
        // Handle error
        console.error('logout failed', response);
    }
}

</script>

<template>
    <form method="POST" class="m-auto flex flex-col gap-2 max-w-86" @submit.prevent="handleSubmit">
        <div class="flex flex-col gap-1 max-w-86">
            <label for="email">Email</label>
            <input class="border" type="email" id="email" name="email" placeholder="Entrez votre email" required v-model="credentials.email">
        </div>

        <div class="flex flex-col gap-1 max-w-86">
            <label for="password">Mot de passe</label>
            <input class="border" type="password" id="password" name="password" placeholder="Entrez votre password" required v-model="credentials.password">
        </div>

        <button type="submit" class="bg-blue-500 px-2 py-1">Confirmer</button>
    </form>
    <button @click="handleLogout" class="bg-red-500 px-2 py-1">Déconnexion</button>
</template>