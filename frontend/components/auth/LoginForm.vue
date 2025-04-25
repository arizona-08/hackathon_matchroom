<template>
  <form @submit.prevent="onSubmit" class="space-y-6 w-full max-w-sm mx-auto">

    <!-- Champ email -->
    <div>
      <label for="email" class="block text-lg font-semibold text-[#000] mb-1">
        e-mail..
      </label>
      <input
        v-model="credentials.email"
        type="email"
        id="email"
        required
        placeholder="@gmail.com"
        class="w-full px-4 py-2 rounded-md border border-soft-green bg-custom-white text-gray-700
               placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-soft-green"
      />
    </div>

    <!-- Champ mot de passe -->
    <div>
      <label for="password" class="block text-lg font-semibold text-[#000] mb-1">
        Mot de passe..
      </label>
      <input
        v-model="credentials.password"
        type="password"
        id="password"
        required
        placeholder="••••••"
        class="w-full px-4 py-2 rounded-lg border border-soft-green bg-custom-white text-gray-700
               placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-soft-green"
      />
    </div>

    <!-- Bouton connexion -->
    <button
      type="submit"
      class="w-full bg-primary hover:bg-soft-green text-white font-semibold py-6 rounded-lg transition duration-200 text-center mb-2"
    >
      Se connecter
    </button>

    <!-- Mot de passe oublié -->
    <div class="text-left text-sm text-[#000]">
      <NuxtLink to="/auth/forgot-password" class="hover:underline text-black flex items-center gap-1 font-medium">
      Mot de passe oublier <span class="text-lg leading-none">›</span>
      </NuxtLink>
    </div>

    <div class="text-left text-sm text-[#000]">
      <NuxtLink to="/auth/register" class="hover:underline text-black text-xl flex items-center gap-1 font-medium">
      S'inscrire 
      </NuxtLink>
    </div>


  </form>
</template>

<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { login } from '~/lib/auth'

const credentials = reactive({ email: '', password: '' })
const router = useRouter()

async function onSubmit() {
  const response = await login(credentials)
  if (response.status === 200) {
    router.push('/')
  } else {
    console.error('login failed', response)
  }
}
</script>
