<template>
    <div class="swipe-page">
  
      <main class="main-content">
        <div v-if="currentRoom" class="card-container">
          <CarouselItem
            :item="{
              title: currentRoom.name,
              address: currentRoom.hotel.address || '',
              city: currentRoom.hotel.city || '',
              price: currentRoom.price_per_night,
              capaxcity: currentRoom.capacity,
              stars: currentRoom.hotel.rating_average || 0,
              tags: [],
              img: currentRoom.photo_url,
              link: `/hotel/rooms/${currentRoom.id}`
            }"
            :scale="true"
          />
  
          <div class="buttons">
            <button class="btn-pass" @click="handleSwipe('pass')">Je n'aime pas</button>
            <button class="btn-like" @click="handleSwipe('like')">J'aime</button>
          </div>
        </div>
  
        <div v-else class="no-more">
          <p>Plus de chambres à swiper 😔</p>
        </div>
      </main>
  
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import { swipe } from '~/lib/swipe';
  import Header from '~/components/layout/Header.vue'; // <<< MANQUAIT !!
  import Footer from '~/components/layout/Footer.vue';
  import CarouselItem from '~/components/Carousel/CarouselItem.vue';
  
  const rooms = ref<any[]>([]);
  const currentRoom = ref<any | null>(null);
  const userId = 1; // Remplacer plus tard par l'id du user connecté
  
  onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/rooms');
    const data = await response.json();
    console.log('Response reçu de /api/rooms:', data);

    // Modification ici pour accéder au tableau à l'intérieur de data.rooms
    rooms.value = data.rooms;
    nextRoom();
  } catch (error) {
    console.error('Erreur en chargeant les rooms:', error);
  }
});

  
  function nextRoom() {
      currentRoom.value = rooms.value.shift() || null;
  }
  
  function handleSwipe(action: 'like' | 'pass') {
      swipe(userId, currentRoom, nextRoom, action);
  }
  </script>
  
  <style scoped>
  .swipe-page {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }
  
  .main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center; /* centre HORIZONTAL */
    justify-content: center; /* centre VERTICAL */
    padding: 2rem 1rem;
  }
  
  .card-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
  }
  
  .buttons {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
  }
  
  .btn-like {
    background-color: #4CAF50;
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 30px;
    font-size: 1.2rem;
    cursor: pointer;
  }
  
  .btn-pass {
    background-color: #f44336;
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 30px;
    font-size: 1.2rem;
    cursor: pointer;
  }
  
  .no-more {
    text-align: center;
    font-size: 1.5rem;
    color: #999;
  }
  </style>
  