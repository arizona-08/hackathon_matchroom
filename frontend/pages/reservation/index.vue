<template>
    <div class="bg-[#E9EDF1] min-h-screen py-10 px-4">
      <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">
  
        <div class="bg-white rounded-lg shadow-md p-6 md:col-span-2 space-y-8">
          <h2 class="text-2xl font-bold text-[#083A31] mb-4">Demande de réservation</h2>
  
          <div>
            <h3 class="text-lg font-semibold mb-2">1. Choisissez vos dates</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block font-medium text-sm mb-1">Date d'arrivée</label>
                <input v-model="checkIn" type="date" class="border w-full p-2 rounded" />
              </div>
              <div>
                <label class="block font-medium text-sm mb-1">Date de départ</label>
                <input v-model="checkOut" type="date" class="border w-full p-2 rounded" />
              </div>
            </div>
            <div v-if="availabilityError" class="text-red-600 text-sm mt-2">
              {{ availabilityError }}
            </div>
          </div>
  
          <div>
            <h3 class="text-lg font-semibold mb-2">2. Choisissez quand vous souhaitez payer</h3>
            <div class="space-y-3">
              <label class="flex items-center gap-2">
                <input type="radio" name="paiement" checked class="accent-[#083A31]" />
                <span>Payer {{ totalPrice }} € maintenant</span>
              </label>
              <label class="flex items-center gap-2 text-gray-400 cursor-not-allowed">
                <input type="radio" disabled />
                <span>Payer plus tard (bientôt disponible)</span>
              </label>
              <label class="flex items-center gap-2 text-gray-400 cursor-not-allowed">
                <input type="radio" disabled />
                <span>3 fois sans frais (bientôt disponible)</span>
              </label>
            </div>
            <button
              class="mt-4 bg-[#083A31] text-white px-6 py-2 rounded hover:bg-[#3F6868] disabled:opacity-50 disabled:cursor-not-allowed"
              @click="submitReservation"
              :disabled="!datesValid || !isAvailable"
            >
              Payer maintenant
            </button>
          </div>
  
          <div>
            <h3 class="text-lg font-semibold mb-2">3. Vérifiez votre demande</h3>
            <p class="text-sm text-gray-500">Votre demande sera traitée une fois validée.</p>
          </div>
        </div>
  
        <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-lg font-semibold text-[#083A31] mb-4">Récapitulatif</h3>
          <div v-if="room">
            <img :src="room.photo_url || 'https://via.placeholder.com/300x200?text=Chambre'" class="w-full h-40 object-cover rounded mb-4" />
            <p class="font-bold">{{ room.name }}</p>
            <p class="text-sm text-gray-600 mb-4">{{ room.hotel?.name }}</p>
  
            <div class="text-sm space-y-1">
              <p><strong>Date d'arrivée :</strong> {{ checkIn }}</p>
              <p><strong>Date de départ :</strong> {{ checkOut }}</p>
              <p><strong>Nombre de nuits :</strong> {{ numberOfNights }}</p>
              <p><strong>Voyageurs :</strong> {{ guests }}</p>
              <p><strong>Prix par nuit :</strong> {{ room.price_per_night }} €</p>
              <p class="font-semibold mt-2">Total : {{ totalPrice }} €</p>
            </div>

          </div>
        </div>
  
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, watch, onMounted } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import { api } from '~/lib/api'
  
  const route = useRoute()
  const router = useRouter()
  const room = ref(null)
  const checkIn = ref('')
  const checkOut = ref('')
  const guests = ref(1)
  const negotiatedPrice = ref(null)
  const availabilityError = ref('')
  const isAvailable = ref(true)
  
  const numberOfNights = computed(() => {
    const d1 = new Date(checkIn.value)
    const d2 = new Date(checkOut.value)
    const diff = d2 - d1
    return diff > 0 ? Math.ceil(diff / (1000 * 60 * 60 * 24)) : 0
  })
  
  const totalPrice = computed(() => {
    return negotiatedPrice.value ?? (room.value ? room.value.price_per_night * numberOfNights.value : 0)
  })
  
  const datesValid = computed(() => checkIn.value && checkOut.value && numberOfNights.value > 0)
  
  watch([checkIn, checkOut], async () => {
    if (!datesValid.value) return
  
    const { data } = await api.post('/api/reservations/check-availability', {
      room_id: room.value.id,
      start_date: checkIn.value,
      end_date: checkOut.value,
    })
  
    isAvailable.value = data.available
    availabilityError.value = data.available ? '' : "Cette chambre n'est plus disponible pour les dates choisies 😭"
  })
  
  onMounted(async () => {
    const roomId = route.query.room_id
    checkIn.value = route.query.check_in || ''
    checkOut.value = route.query.check_out || ''
    guests.value = route.query.guests || 1
  
    if (!roomId) return
    const { data } = await api.get(`/api/rooms/${roomId}`)
    room.value = data.room
  
    if (route.query.price) {
      negotiatedPrice.value = parseFloat(route.query.price)
    }
  })
  
  async function submitReservation() {
    if (!datesValid.value || !isAvailable.value) return
  
    try {
      await api.post('/api/reservations', {
        room_id: room.value.id,
        start_date: checkIn.value,
        end_date: checkOut.value,
        price_paid: totalPrice.value,
        guests: guests.value,
        status: 'confirmed',
        negotiation_id: route.query.negotiation_id || null
      })
  
      router.push({
        path: '/reservation/success',
        query: {
          room_id: room.value.id,
          check_in: checkIn.value,
          check_out: checkOut.value,
          guests: guests.value,
          total_price: totalPrice.value
        }
      })
    } catch (error) {
      console.error('[RESERVATION ERROR]', error)
      availabilityError.value = "Erreur lors de la réservation. Veuillez réessayer."
    }
  }
  </script>
  