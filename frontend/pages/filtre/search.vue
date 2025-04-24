<template>
    <div class="max-w-5xl mx-auto mt-10 p-4">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">My Trips</h2>
        <button @click="showModal = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          + New Trip
        </button>
      </div>
  
      <div v-if="filters.length === 0" class="text-gray-500 text-center">
        No saved trips yet.
      </div>
  
      <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div
          v-for="filter in filters"
          :key="filter.id"
          class="bg-gray-100 p-4 rounded shadow hover:bg-gray-200 cursor-pointer"
          @click="goToResults(filter.id)"
        >
          <h3 class="font-semibold text-lg">{{ filter.name }}</h3>
          <p class="text-sm text-gray-600 mt-1">Destination: {{ filter.city }}</p>
        </div>
      </div>
  
      <NewTripModal v-if="showModal" @close="showModal = false" @create="handleTripCreate" />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import NewTripModal from '~/components/NewTripModal.vue'
  import { api } from '~/lib/api'
  import { createSearchPreset, getUserFilters } from '~/lib/search'
  import { useRouter } from 'vue-router'
  
  const showModal = ref(false)
  const filters = ref([])
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
        user_id: user.value.id
      }
  
      const response = await createSearchPreset(payload)
      const created = response.data
  
      filters.value.push(created)
      showModal.value = false
    } catch (err) {
      console.error('[CREATE TRIP ERROR]', err)
    }
  }
  
  function goToResults(presetId) {
    router.push(`/hotel/room?preset_id=${presetId}`)
  }
  </script>
  