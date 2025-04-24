<template>
    <div class="max-w-5xl mx-auto mt-10 p-4">
      <h2 class="text-2xl font-bold mb-6">Résultats de la recherche</h2>
  
      <div v-if="rooms.length === 0" class="text-gray-500 text-center">
        Aucune chambre trouvée.
      </div>
  
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="room in rooms" :key="room.id" class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">{{ room.name }}</h3>
            <p class="text-sm text-gray-600 mb-1">Capacité : {{ room.capacity }} personnes</p>
            <p class="text-sm text-gray-600 mb-1">Prix : {{ room.price_per_night }} € / nuit</p>
            <p class="text-sm text-gray-600 mb-4">Hôtel : {{ room.hotel?.name || 'Non spécifié' }}</p>

            <NuxtLink
            :to="`/negociation?room_id=${room.id}`"
            class="inline-block bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 text-sm"
            >
            Négocier
            </NuxtLink>

        </div>
        </div>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue'
  import { useRoute } from 'vue-router'
  import { runSearchPreset } from '~/lib/search'
  
  const rooms = ref([])
  const route = useRoute()
  
  onMounted(async () => {
    const presetId = route.query.preset_id
    if (!presetId) return
  
    try {
      const res = await runSearchPreset(presetId)
      rooms.value = res.data || []
    } catch (err) {
      console.error('[LOAD SEARCH RESULTS ERROR]', err)
    }
  })
  </script>
  