<template>
    <form @submit.prevent="onSubmit" class="w-full max-w-4xl mx-auto space-y-6 px-6">
  
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center">
        <!-- Colonne de gauche -->
        <div class="space-y-6 w-full max-w-sm">
          <div>
            <label for="name" class="block text-lg font-semibold text-[#000] mb-1">Nom..</label>
            <input
              v-model="credentials.name"
              type="text"
              id="name"
              placeholder="Nom"
              required
              class="w-full px-3 py-1.5 rounded-lg border border-soft-green bg-custom-white placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-soft-green"
            />
          </div>
  
          <div>
            <label for="firstname" class="block text-lg font-semibold text-[#000] mb-1">Prénom..</label>
            <input
              v-model="credentials.firstname"
              type="text"
              id="Prénom"
              placeholder="Prénom"
              required
              class="w-full px-3 py-1.5 rounded-lg border border-soft-green bg-custom-white placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-soft-green"
            />
          </div>
  
            <div>
            <label for="role" class="block text-lg font-semibold text-[#000] mb-1">Rôle..</label>
            <select
              v-model="credentials.role"
              id="role"
              class="w-full px-3 py-1.5 rounded-lg border border-soft-green bg-custom-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-soft-green"
            >
              <option value="voyageur">Voyageur</option>
              <option value="hotelier">Hotelier</option>
            </select>
            </div>
        </div>
  
        <!-- Colonne de droite -->
        <div class="space-y-6 w-full max-w-sm">
          <div>
            <label for="email" class="block text-lg font-semibold text-[#000] mb-1">e-mail..</label>
            <input
              v-model="credentials.email"
              type="email"
              id="email"
              placeholder="@gmail.com"
              required
              class="w-full px-3 py-1.5 rounded-lg border border-soft-green bg-custom-white placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-soft-green"
            />
          </div>
  
          <div>
            <label for="password" class="block text-lg font-semibold text-[#000] mb-1">Mot de passe..</label>
            <input
              v-model="credentials.password"
              type="password"
              id="password"
              placeholder="••••••"
              required
              class="w-full px-3 py-1.5 rounded-lg border border-soft-green bg-custom-white placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-soft-green"
            />
          </div>
  
          <div>
            <label for="confirmPassword" class="block text-lg font-semibold text-[#000] mb-1">Confirmez mot de passe..</label>
            <input
              v-model="credentials.password_confirmation"
              type="password"
              id="confirmPassword"
              placeholder="••••••"
              required
              class="w-full px-3 py-1.5 rounded-lg border border-soft-green bg-custom-white placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-soft-green"
            />
          </div>
        </div>
      </div>
  
      <!-- Bouton -->
      <div class="text-center pt-4">
        <button
          type="submit"
          class="bg-primary hover:bg-soft-green text-white font-medium px-22 py-4 rounded-lg transition duration-200"
        >
          S’inscrire
        </button>
      </div>
  
    </form>
</template>

<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { register } from '~/lib/auth'

const router = useRouter()
const credentials = reactive({
  name: '',
  firstname: '',
  phone: '',
  email: '',
  role: 'voyageur',
  password: '',
  password_confirmation: ''
})

async function onSubmit() {
  const response = await register(credentials)
  if (response.status === 201) {
    router.push('/auth/login')
  } else {
    console.error('Registration failed', response)
  }
}
</script>
