<template>
  <div class="bg-custom-white min-h-screen py-10 px-4">
    <div class="max-w-3xl mx-auto bg-custom-white border border-primary rounded-tr-lg rounded-br-lg rounded-bl-lg shadow-md p-8 flex flex-col items-center space-y-6">

      <h2 class="text-3xl font-bold text-[#083A31] text-center">Réservation confirmée !</h2>
      <p class="text-gray-600 text-center">Merci pour votre confiance. Voici les détails de votre réservation :</p>

      <div class="w-full space-y-4">
        <div v-if="room">
          <img 
            :src="room.photo_url || 'https://via.placeholder.com/300x200?text=Chambre'" 
            class="w-full h-44 object-cover rounded mb-6" 
          />

          <div class="text-sm space-y-2 text-gray-700">
            <p><strong>Chambre :</strong> {{ room.name }}</p>
            <p><strong>Hôtel :</strong> {{ room.hotel?.name }}</p>
            <p><strong>Date d'arrivée :</strong> {{ checkIn }}</p>
            <p><strong>Date de départ :</strong> {{ checkOut }}</p>
            <p><strong>Nombre de voyageurs :</strong> {{ guests }}</p>
            <p class="font-semibold text-lg text-primary mt-4">Total payé : {{ totalPrice }} €</p>
          </div>
        </div>
      </div>

      <NuxtLink 
        to="/" 
        class="mt-8 bg-[#083A31] text-white px-6 py-2 rounded hover:bg-[#3F6868] transition"
      >
        Retour à l'accueil
      </NuxtLink>
      
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { api } from '~/lib/api'

const route = useRoute()
const checkIn = route.query.check_in || ''
const checkOut = route.query.check_out || ''
const guests = route.query.guests || 1
const totalPrice = route.query.total_price || 0

const room = ref(null)

onMounted(async () => {
  if (!route.query.room_id) return
  const { data } = await api.get(`/api/rooms/${route.query.room_id}`)
  room.value = data.room
})
</script>
