<template>
  <div class="max-w-5xl mx-auto mt-10 p-4">
    <h2 class="text-2xl font-bold mb-6">Résultats de la recherche</h2>

    <div v-if="rooms.length === 0" class="text-gray-500 text-center">
      Aucune chambre trouvée.
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="room in rooms"
        :key="room.id"
        class="bg-white p-4 rounded shadow space-y-2"
      >
        <h3 class="text-lg font-semibold">{{ room.name }}</h3>
        <p class="text-sm text-gray-600">Capacité : {{ room.capacity }} personnes</p>
        <p class="text-sm text-gray-600">Prix : {{ room.price_per_night }} € / nuit</p>
        <p class="text-sm text-gray-600 mb-2">Hôtel : {{ room.hotel?.name || 'Non spécifié' }}</p>

        <div class="flex gap-2">
          <NuxtLink
            :to="`/negociation?room_id=${room.id}`"
            class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 text-sm"
          >
            Négocier
          </NuxtLink>
          <button
            @click="goToReservation(room.id)"
            class="bg-[#083A31] text-white px-4 py-2 rounded hover:bg-[#3F6868] text-sm"
          >
            Réserver
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { runSearchPreset } from '~/lib/search'
import { api } from '~/lib/api'

const rooms = ref([])
const route = useRoute()
const router = useRouter()

function goToReservation(roomId) {
  router.push({ path: '/reservation', query: { room_id: roomId } })
}

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
