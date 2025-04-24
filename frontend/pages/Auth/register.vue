<script setup>


import { register } from '~/lib/auth';
const credentials = reactive({
    name: '',
    firstname: '',
    email: '',
    type: '',
    password: '',
    password_confirmation: ''
});

const router = useRouter();

async function handleSubmit() {

    const response = await register(credentials);
    if (response.status === 201) {
        // Handle successful registration
        console.log('Registration successful');
        router.push('/auth/login');
    } else {
        // Handle error
        console.error('Registration failed', response);
    }
}

</script>

<template>
    <form method="POST" class="m-auto flex flex-col gap-2 max-w-86" @submit.prevent="handleSubmit">
        <div class="flex flex-col gap-1 max-w-86">
            <label for="nom">Nom</label>
            <input class="border" type="text" id="nom" name="nom" placeholder="Entrez votre nom" required v-model="credentials.name">
        </div>

        <div class="flex flex-col gap-1 max-w-86">
            <label for="Prénom">Prénom</label>
            <input class="border" type="text" id="prenom" name="prenom" placeholder="Entrez votre prenom" required v-model="credentials.firstname">
        </div>

        <div class="flex flex-col gap-1 max-w-86">
            <label for="email">Email</label>
            <input class="border" type="email" id="email" name="email" placeholder="Entrez votre email" required v-model="credentials.email">
        </div>

        <div class="flex flex-col gap-1 max-w-86">
            <label for="user-type">Type d'utilisateur</label>
            <select class="border" id="user-type" v-model="credentials.type" required>
                <option value="" disabled selected>Choisissez un type d'utilisateur</option>
                <option value="voyageur">Voyageur</option>
                <option value="hotelier">Hôtelier</option>
            </select>
        </div>

        <div class="flex flex-col gap-1 max-w-86">
            <label for="password">Mot de passe</label>
            <input class="border" type="password" id="password" name="password" placeholder="Entrez votre password" required v-model="credentials.password">
        </div>

        <div class="flex flex-col gap-1 max-w-86">
            <label for="confirmation_password">Confimation du mot de passe</label>
            <input class="border" type="password" id="confirmation_password" name="confirmation_password" placeholder="Confirmer mot de passe" required v-model="credentials.password_confirmation">
        </div>

        <button type="submit" class="bg-blue-500 px-2 py-1">Confirmer</button>
    </form>
</template>