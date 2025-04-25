<template>
  <div class="min-h-screen bg-custom-white py-16 px-6 flex justify-center items-center">
    <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-5 gap-10">

      <div class="col-span-1 md:col-span-2 flex items-center justify-center h-[80vh]">

        <button @click="showModal = true"
          class="w-64 h-52 border-2 border-primary rounded-tr-md rounded-br-md rounded-bl-md flex flex-col items-center justify-center hover:bg-gray-100 transition">
          <span class="text-3xl font-bold text-primary">+</span>
          <span class="text-lg font-semibold text-black mt-2">Nouvelle recherche</span>
        </button>
      </div>


      <div class="hidden md:flex justify-center items-center col-span-1">
        <div class="h-64 w-px bg-soft-green"></div>
      </div>

      <div
        :class="filters.length === 0 ? 'col-span-1 md:col-span-2 space-y-4 overflow-y-auto hide-scrollbar' : 'col-span-1 md:col-span-2 overflow-y-auto max-h-[80vh] space-y-4 overflow-y-auto hide-scrollbar' ">

        <div v-if="filters.length === 0"
          class="flex flex-col justify-center items-center text-center text-gray-600 text-sm mt-4 px-4 h-full ">
          <p>Aucune recherche enregistrée pour le moment.</p>
          <p class="mt-1">Faites une première recherche pour la retrouver ici</p>
        </div>

        <div v-else v-for="(filter, index) in filters" :key="filter.id"
          class="flex bg-custom-white rounded-tr-lg rounded-br-lg rounded-bl-lg border-2 border-primary overflow-hidden cursor-pointer hover:shadow-md transition h-32"
          @click="goToResults(filter.id)">
          <div class="relative w-40 h-full min-w-[10rem]">
            <img :src="`/img/preset${(index % 3) + 1}.png`" alt="preset image" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-transparent to-custom-white opacity-80"></div>
          </div>


          <div class="flex-1 px-4 py-3 text-right text-sm text-gray-700 flex flex-col justify-center">
            <h3 class="text-lg font-bold text-black mb-1">{{ filter.city }}</h3>
            <p v-if="filter.start_date && filter.end_date">{{ formatDate(filter.start_date) }} – {{
              formatDate(filter.end_date) }}</p>
            <p v-if="filter.hotel_name">{{ filter.hotel_name }}</p>

            <!-- Étoiles -->
            <div v-if="filter.stars" class="flex justify-end gap-1 mt-1">
              <img v-for="n in 5" :key="n"
                :src="n <= filter.stars ? '/svg/Etoile_Jaune.svg' : '/svg/Etoile_Transparent.svg'" alt="star"
                class="w-4 h-4" />
            </div>

            <p v-if="filter.guests">{{ filter.guests }} Personne<span v-if="filter.guests > 1">s</span></p>
            <p v-if="filter.beds">{{ filter.beds }} Lit<span v-if="filter.beds > 1">s</span></p>
          </div>

        </div>





      </div>

      <NewTripModal v-if="showModal" @close="showModal = false" @create="handleTripCreate" />
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { api } from '~/lib/api'
import { getUserFilters, createSearchPreset } from '~/lib/search'
import NewTripModal from '~/components/NewTripModal.vue'

const filters = ref([])
const showModal = ref(false)
const user = ref(null)
const router = useRouter()

onMounted(async () => {
  try {
    const res = await api.get('/api/user')
    user.value = res.data

    if (user.value?.id) {
      const response = await getUserFilters(user.value.id)
      filters.value = response.data
    }
  } catch (error) {
    console.error('[AUTH OR FILTERS LOAD ERROR]', error)
  }
})

async function handleTripCreate(tripData) {
  try {
    const payload = {
      ...tripData,
      user_id: user.value.id,
      name: tripData.name || `Trip à ${tripData.city || 'destination'}`
    }
    const response = await createSearchPreset(payload)
    filters.value.push(response.data)
    showModal.value = false
  } catch (err) {
    console.error('[CREATE TRIP ERROR]', err)
  }
}

function goToResults(presetId) {
  router.push(`/hotel/room?preset_id=${presetId}`)
}

function formatDate(dateStr) {
  const options = { day: '2-digit', month: 'short' }
  return new Date(dateStr).toLocaleDateString('fr-FR', options)
}

</script>

<style scoped>
.hide-scrollbar {
  scrollbar-width: none; 
  -ms-overflow-style: none;  
}

.hide-scrollbar::-webkit-scrollbar {
  display: none; 
}

</style>