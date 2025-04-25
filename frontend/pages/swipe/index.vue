<template>
  <div class="swipe-page">
   

    <main class="main-content">
      <div v-if="currentRoom" class="card-container">
        <CarouselItemSwipe
          :item="{
            title: currentRoom.name,
            address: currentRoom.hotel.address || '',
            city: currentRoom.hotel.city || '',
            price: currentRoom.price_per_night,
            capaxcity: currentRoom.capacity,
            stars: currentRoom.hotel.rating_average || 0,
            tags: [],
            img: currentRoom.photo_url,
            link: `/hotel/rooms/${currentRoom.id}`,
            images: currentRoom.images?.map(img => img.photo_url) || []
          }"
          @swiped="handleSwipe"
        />

        <!-- 🔥 Ici les boutons SVG sous la carte -->
        <div class="svg-buttons">
          <NuxtImg
            src="/img/svgs/NO.svg"
            
            class="icon-svg hover:scale-110 transition"
            @click="handleSwipe('pass')"
            alt="no"
          />
          <NuxtImg
            src="/img/svgs/Favori.svg"
            class="icon-svg favori-svg"
            @click="triggerPulse"
            alt="favori"
            :class="{ pulse: isFavori }"
          />
          <NuxtImg
            src="/img/svgs/Yes.svg"
            class="icon-svg hover:scale-110 transition"
            @click="handleSwipe('like')"
            alt="yes"
          />
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
import Header from '~/components/layout/Header.vue';
import Footer from '~/components/layout/Footer.vue';
import CarouselItemSwipe from '~/components/Carousel/CarouselItemSwipe.vue';

const rooms = ref<any[]>([]);
const currentRoom = ref<any | null>(null);
const userId = 1; // À remplacer par le vrai user connecté

const isFavori = ref(false);

function triggerPulse() {
  isFavori.value = true;
  setTimeout(() => {
    isFavori.value = false;
  }, 600);
}

onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/rooms');
    const data = await response.json();
    console.log('Response reçu de /api/rooms:', data);

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
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
}

.card-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}

.svg-buttons {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-top: 1.5rem;
}

.icon-svg {
  width: 60px;
  height: 60px;
  cursor: pointer;
}

.pulse {
  animation: pulse 0.6s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.2); }
  100% { transform: scale(1); }
}

.no-more {
  text-align: center;
  font-size: 1.5rem;
  color: #999;
}
</style>
