<template>
    <div class="reservations-container p-6 max-w-6xl mx-auto">
      <h1 class="text-3xl font-bold mb-6">Mes Réservations</h1>
  
      <div v-if="loading" class="text-center py-8">
        <p>Chargement de vos réservations...</p>
      </div>
  
      <div v-else-if="reservations.length === 0" class="text-center py-8 bg-gray-100 rounded">
        <p class="text-lg">Vous n'avez pas encore de réservations.</p>
        <router-link to="/" class="text-blue-600 hover:underline mt-4 inline-block">
          Parcourir les chambres disponibles
        </router-link>
      </div>
  
      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div v-for="reservation in reservations" :key="reservation.id" class="reservation-card bg-white rounded-lg shadow p-5">
          <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">{{ reservation.room.name }}</h2>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
              {{ formatDate(reservation.start_date) }} - {{ formatDate(reservation.end_date) }}
            </span>
          </div>
          
          <div class="mb-3">
            <p class="text-gray-700">{{ reservation.room.description }}</p>
          </div>
          
          <div class="mb-3">
            <p><span class="font-medium">Hôtel:</span> {{ reservation.room.hotel?.name }}</p>
            <p><span class="font-medium">Prix par nuit:</span> {{ reservation.room.price_per_night }} €</p>
            <p><span class="font-medium">Durée:</span> {{ calculateDuration(reservation.start_date, reservation.end_date) }} nuits</p>
            <p class="font-semibold mt-1">
              Total: {{ calculateTotal(reservation.room.price_per_night, reservation.start_date, reservation.end_date) }} €
            </p>
          </div>
          
          <button 
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 mt-2"
            @click="cancelReservation(reservation.id)"
          >
            Annuler la réservation
          </button>
        </div>
      </div>
  
      <p v-if="message" :class="['mt-4 p-3 rounded', messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700']">
        {{ message }}
      </p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const reservations = ref([]);
  const loading = ref(true);
  const message = ref('');
  const messageType = ref('');
  
  async function fetchReservations() {
    loading.value = true;
    try {
      const response = await axios.get('/api/reservations');
      reservations.value = response.data;
    } catch (error) {
      console.error('Erreur lors de la récupération des réservations:', error);
      showMessage('Impossible de charger vos réservations', 'error');
    } finally {
      loading.value = false;
    }
  }
  
  async function cancelReservation(reservationId) {
    if (!confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
      return;
    }
    
    try {
      await axios.delete(`/api/reservations/${reservationId}`);
      // Retirer la réservation de la liste
      reservations.value = reservations.value.filter(r => r.id !== reservationId);
      showMessage('Réservation annulée avec succès', 'success');
    } catch (error) {
      console.error('Erreur lors de l\'annulation de la réservation:', error);
      showMessage('Impossible d\'annuler la réservation', 'error');
    }
  }
  
  function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR');
  }
  
  function calculateDuration(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const diffTime = Math.abs(end - start);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
  }
  
  function calculateTotal(pricePerNight, startDate, endDate) {
    const nights = calculateDuration(startDate, endDate);
    return (nights * pricePerNight).toFixed(2);
  }
  
  function showMessage(text, type) {
    message.value = text;
    messageType.value = type;
    setTimeout(() => {
      message.value = '';
    }, 5000);
  }
  
  onMounted(() => {
    fetchReservations();
  });
  </script>
  
  <style scoped>
  .reservations-container {
    min-height: 70vh;
  }
  
  .reservation-card {
    transition: transform 0.2s;
  }
  
  .reservation-card:hover {
    transform: translateY(-3px);
  }
  </style>