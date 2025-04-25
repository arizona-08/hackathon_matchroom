<template>
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <h2 class="text-3xl font-bold mb-8 text-[#083A31] text-center">Résultats de la recherche</h2>

    <div v-if="rooms.length === 0" class="text-gray-500 text-center">
      Aucune chambre trouvée.
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div
        v-for="room in rooms"
        :key="room.id"
        class="bg-custom-white border border-primary rounded-2xl overflow-hidden shadow-lg flex flex-col"
      >
        <div class="relative h-56">
          <NuxtImg 
            :src="room.photo_url || 'https://via.placeholder.com/400x300?text=Chambre'" 
            alt="" 
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        </div>

        <div class="flex-1 p-4 flex flex-col justify-between space-y-4">
          <div>
            <div class="flex items-center gap-2 mb-2">
              <div class="flex gap-0.5">
                <NuxtImg v-for="i in room.hotel?.number_of_stars || 0" :key="i" src="/img/svgs/Etoile_Jaune.svg" alt="" class="w-4 h-4" />
              </div>
            </div>

            <h3 class="text-xl font-semibold text-[#083A31]">{{ room.name }}</h3>
            <p class="text-sm text-gray-600">{{ room.hotel?.address }} - {{ room.hotel?.city }}</p>

            <div class="mt-4 text-sm text-gray-700 space-y-1">
              <p><strong>Prix :</strong> {{ room.price_per_night }}€ / nuit</p>
              <p><strong>Capacité :</strong> {{ room.capacity }} personnes</p>
            </div>

            <div class="flex flex-wrap gap-2 mt-4">
              <span 
                v-for="tag in room.equipement || []" 
                :key="tag"
                class="bg-primary text-white rounded-full px-2 py-1 text-[10px]"
              >
                {{ tag }}
              </span>
            </div>
          </div>

          <div class="flex gap-3 mt-6">
            <NuxtLink
              :to="`/negociation?room_id=${room.id}`"
              class="flex-1 bg-green-700 hover:bg-green-800 text-white py-2 rounded-full text-center font-semibold text-sm transition"
            >
              Négocier
            </NuxtLink>

            <button
              @click="goToReservation(room.id)"
              class="flex-1 bg-[#083A31] hover:bg-[#3F6868] text-white py-2 rounded-full font-semibold text-sm transition"
            >
              Réserver
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { runSearchPreset } from '~/lib/search'

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
