<template>
    <div class="min-h-screen bg-[#E9EDF1] flex items-center justify-center py-10 px-4">
      <div class="bg-white shadow-lg rounded-xl p-8 max-w-2xl w-full text-center">
        <h1 class="text-2xl font-bold text-[#083A31] mb-4">Réservation confirmée !</h1>
        <p class="text-gray-600 mb-6">Merci pour votre confiance. Voici les détails de votre réservation :</p>
  
        <div class="bg-gray-50 p-4 rounded-lg shadow text-left text-sm">
          <p><strong>Chambre :</strong> {{ room?.name || 'Non spécifiée' }}</p>
          <p><strong>Hôtel :</strong> {{ room?.hotel?.name || '...' }}</p>
          <p><strong>Date d'arrivée :</strong> {{ checkIn }}</p>
          <p><strong>Date de départ :</strong> {{ checkOut }}</p>
          <p><strong>Nombre de voyageurs :</strong> {{ guests }}</p>
          <p><strong>Montant payé :</strong> {{ totalPrice }} €</p>
        </div>
  
        <NuxtLink to="/profil" class="inline-block mt-6 bg-[#083A31] text-white px-6 py-2 rounded hover:bg-[#3F6868]">
          Voir mon profil
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