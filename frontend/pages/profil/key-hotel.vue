<template>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
      <h1 class="text-xl font-bold mb-4 text-center text-[#083A31]">Entrer votre clé d'accès hôtel</h1>
  
      <form @submit.prevent="submitAccessKey" class="space-y-4">
        <input
          v-model="accessKey"
          type="password"
          placeholder="Clé confidentielle"
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#083A31]"
        />
        <button
          type="submit"
          class="w-full bg-[#083A31] text-white py-2 rounded hover:bg-[#062a23] transition"
        >
          Valider la clé
        </button>
      </form>
  
      <p v-if="error" class="text-red-500 mt-4 text-center">{{ error }}</p>
      <p v-if="success" class="text-green-600 mt-4 text-center">✅ Clé acceptée, vous pouvez créer votre hôtel !</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  import { api } from '~/lib/api'
  
  const accessKey = ref('')
  const error = ref('')
  const success = ref(false)
  const router = useRouter()
  
  async function submitAccessKey() {
    error.value = ''
    success.value = false
  
    try {
      const response = await api.post('/api/validate-hotel-key', { access_key: accessKey.value })
  
      if (response.status === 200) {
        success.value = true
        router.push('/hotel/create-hotel')
      }
    } catch (err) {
      error.value = err.response?.data?.message || "Clé invalide ou erreur serveur."
    }
  }
  </script>
  