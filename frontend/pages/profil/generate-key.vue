<template>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
      <h2 class="text-xl font-bold mb-4">Générer une clé d’accès pour un utilisateur</h2>
  
      <select v-model="selectedUser" class="w-full border p-2 rounded mb-4">
        <option disabled value="">Sélectionnez un utilisateur</option>
        <option v-for="user in users" :key="user.id" :value="user.id">
          {{ user.name }} - {{ user.email }}
        </option>
      </select>
  
      <button
        @click="generateKey"
        :disabled="!selectedUser"
        class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded"
      >
        Générer
      </button>
  
      <div v-if="generatedKey" class="mt-4 p-3 border border-green-700 bg-green-50 rounded text-green-800">
        <strong>Clé générée pour l’utilisateur {{ selectedUser }} :</strong>
        <p class="mt-1 font-mono">{{ generatedKey }}</p>
      </div>
  
      <div v-if="error" class="mt-4 text-red-600">
        {{ error }}
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { generateHotelKeyForUser } from '~/lib/hotel'
  import { api } from '~/lib/api'
  
  const users = ref([])
  const selectedUser = ref('')
  const generatedKey = ref(null)
  const error = ref('')
  
  onMounted(async () => {
    try {
      const res = await api.get('/api/users') 
      users.value = res.data
    } catch (err) {
      console.error('[USER FETCH ERROR]', err)
    }
  })
  
  async function generateKey() {
    error.value = ''
    generatedKey.value = null
  
    try {
      const res = await generateHotelKeyForUser(selectedUser.value)
      generatedKey.value = res.access_key
    } catch (err) {
      error.value = 'Erreur lors de la génération de la clé.'
      console.error('[GENERATE KEY ERROR]', err)
    }
  }
  </script>
  