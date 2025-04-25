<template>
    <div class="p-6 max-w-xl mx-auto">
      <h2 class="text-xl font-semibold mb-4">Créer un hôtel</h2>
  
      <form @submit.prevent="submitHotel">
        <div class="mb-4">
          <label class="block">Nom de l'hôtel</label>
          <input v-model="form.name" type="text" class="w-full border p-2 rounded" required />
        </div>
  
        <div class="mb-4">
          <label class="block">Description</label>
          <textarea v-model="form.description" class="w-full border p-2 rounded" />
        </div>
  
        <div class="mb-4">
          <label class="block">Adresse</label>
          <input v-model="form.address" type="text" class="w-full border p-2 rounded" required />
        </div>

        <div class="mb-4">
          <label class="block">Ville</label>
          <input v-model="form.city" type="text" class="w-full border p-2 rounded" required />
        </div>
  
        <div class="mb-4">
          <label class="block">Latitude</label>
          <input v-model="form.latitude" type="number" step="any" class="w-full border p-2 rounded" />
        </div>
  
        <div class="mb-4">
          <label class="block">Longitude</label>
          <input v-model="form.longitude" type="number" step="any" class="w-full border p-2 rounded" />
        </div>

        <div class="mb-4">
          <label class="block">Nombre d'étoile</label>
          <input v-model="form.number_of_stars" type="number" step="any" class="w-full border p-2 rounded" />
        </div>
  
        <div class="mb-4">
          <label class="block">Note moyenne (0-5)</label>
          <input v-model="form.rating_average" type="number" step="0.1" min="0" max="5" class="w-full border p-2 rounded" />
        </div>
  
        <div class="mb-4">
          <label class="block">Politique d'annulation</label>
          <input v-model="form.cancellation_policy" type="text" class="w-full border p-2 rounded" />
        </div>
  
        <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded">Créer</button>
      </form>
  
      <p v-if="successMessage" class="text-green-600 mt-4">{{ successMessage }}</p>
      <p v-if="errorMessage" class="text-red-600 mt-4">{{ errorMessage }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { createHotel } from '~/lib/hotel'
  
  const form = ref({
    name: '',
    description: '',
    address: '',
    city: '',
    number_of_stars: '',
    latitude: '',
    longitude: '',
    rating_average: '',
    cancellation_policy: ''
  })
  
  const successMessage = ref('')
  const errorMessage = ref('')
  
  async function submitHotel() {
    try {
      const response = await createHotel(form.value)
      successMessage.value = `Hôtel "${response.data.name}" créé avec succès !`
      errorMessage.value = ''
      form.value = {
        name: '',
        description: '',
        address: '',
        city: '',
        number_of_stars: '',
        latitude: '',
        longitude: '',
        rating_average: '',
        cancellation_policy: ''
      }
    } catch (err) {
      errorMessage.value = err.response?.data?.message || 'Erreur lors de la création'
      successMessage.value = ''
    }
  }
  </script>
  