<template>
  <div class="room-details-container p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-4">{{ room.name }}</h1>
    <p class="text-lg mb-4">{{ room.description }}</p>
    <div class="mb-4">
      <span class="font-semibold">Capacité :</span> {{ room.capacity }} personnes
    </div>
    <div class="mb-4">
      <span class="font-semibold">Prix par nuit :</span> {{ room.price_per_night }} €
    </div>
    <div class="mb-4">
      <span class="font-semibold">Hôtel :</span> {{ room.hotel?.name }}
    </div>

    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block mb-2">Date d'arrivée</label>
        <input 
          type="date" 
          v-model="startDate" 
          class="w-full p-2 border rounded"
          :min="todayFormatted"
        />
      </div>
      <div>
        <label class="block mb-2">Date de départ</label>
        <input 
          type="date" 
          v-model="endDate" 
          class="w-full p-2 border rounded"
          :min="startDate || todayFormatted"
        />
      </div>
    </div>

    <button
      class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
      @click="reserveRoom"
      :disabled="!startDate || !endDate"
    >
      Réserver cette chambre
    </button>

    <p v-if="successMessage" class="text-green-600 mt-4">{{ successMessage }}</p>
    <p v-if="errorMessage" class="text-red-600 mt-4">{{ errorMessage }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const roomId = route.params.id;

const room = ref({});
const startDate = ref('');
const endDate = ref('');
const successMessage = ref('');
const errorMessage = ref('');

const todayFormatted = computed(() => {
  const today = new Date();
  return today.toISOString().split('T')[0];
});

async function fetchRoomDetails() {
  try {
    const response = await axios.get(`/api/rooms/${roomId}`);
    room.value = response.data;
  } catch (error) {
    console.error('Erreur lors de la récupération des détails de la chambre :', error);
  }
}

async function reserveRoom() {
  if (!startDate.value || !endDate.value) {
    errorMessage.value = 'Veuillez sélectionner les dates de séjour';
    return;
  }

  try {
    await axios.post(`/api/rooms/${roomId}/reserve`, {
      start_date: startDate.value,
      end_date: endDate.value
    });
    successMessage.value = 'Réservation effectuée avec succès !';
    errorMessage.value = '';
    
    // Rediriger vers la page des réservations après un court délai
    setTimeout(() => {
      router.push('/my-reservations');
    }, 2000);
  } catch (error) {
    errorMessage.value = error.response?.data?.error || 'Erreur lors de la réservation. Veuillez réessayer.';
    successMessage.value = '';
    console.error('Erreur lors de la réservation :', error);
  }
}

onMounted(() => {
  fetchRoomDetails();
});
</script>

<style scoped>
.room-details-container {
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
</style>