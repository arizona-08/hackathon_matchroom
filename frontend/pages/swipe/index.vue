<template>
  <div class="swipe-page">


    <main class="main-content">
      <div v-if="currentRoom" class="card-container">
        <CarouselItemSwipe :item="{
          title: currentRoom.name,
          address: currentRoom.hotel.address || '',
          city: currentRoom.hotel.city || '',
          price: currentRoom.price_per_night,
          capacity: currentRoom.capacity,
          stars: currentRoom.hotel.rating_average || 0,
          tags: [],
          img: currentRoom.photo_url,
          link: `/hotel/rooms/${currentRoom.id}`,
          images: currentRoom.images?.map(img => img.photo_url) || []
        }" @swiped="handleSwipe" />

        <div class="svg-buttons">
          <!-- NO : Swipe "pass" -->
          <NuxtImg src="/img/svgs/NO.svg" class="icon-svg hover:scale-110 transition" @click="handleSwipe('pass')"
            alt="no" />

          <!-- FAVORI : Ajouter aux favoris -->
          <NuxtImg src="/img/svgs/Favori.svg" class="icon-svg favori-svg" @click="addToFavorites" alt="favori"
            :class="{ pulse: isFavori }" />

          <!-- YES : Démarrer négociation -->
          <NuxtImg src="/img/svgs/Yes.svg" class="icon-svg hover:scale-110 transition" @click="startNego" alt="yes" />
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
import { useRouter } from 'vue-router';
import { swipe } from '~/lib/swipe';
import { addToFavoris } from '~/lib/favoris';
import CarouselItemSwipe from '~/components/Carousel/CarouselItemSwipe.vue';
import { startNegotiation } from '~/lib/negociation'; // ✅ import API négo
import { api } from '~/lib/api'; // ✅ pour récupérer l'user

const rooms = ref<any[]>([]);
const currentRoom = ref<any | null>(null);
const userId = ref<number | null>(null);
const router = useRouter();
const isFavori = ref(false);

onMounted(async () => {
  try {
    const userRes = await api.get('/api/user');
    userId.value = userRes.data.id;

    const response = await fetch('http://localhost:8000/api/rooms');
    const data = await response.json();
    rooms.value = data.rooms;
    nextRoom();
  } catch (error) {
    console.error('Erreur en chargeant les données:', error);
  }
});

function nextRoom() {
  currentRoom.value = rooms.value.shift() || null;
}

function handleSwipe(action: 'pass') {
  swipe(userId.value, currentRoom, nextRoom, action);
}

async function addToFavorites() {
  if (!currentRoom.value) return;

  try {
    await addToFavoris(currentRoom.value.id);
    triggerPulse();
  } catch (error) {
    console.error('Erreur en ajoutant aux favoris:', error);
  }
}

async function startNego() {
  if (!currentRoom.value || !userId.value) return;

  try {
    const res = await startNegotiation({
      room_id: currentRoom.value.id,
      user_id: userId.value
    });

    router.push(`/negociation?room_id=${currentRoom.value.id}`);
  } catch (err) {
    console.error('Erreur lors de la création de la négociation :', err);
  }
}

function triggerPulse() {
  isFavori.value = true;
  setTimeout(() => {
    isFavori.value = false;
  }, 600);
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
  gap: 2.5rem;
  margin-top: 2rem;
}

.icon-svg {
  width: 28px;
  height: 28px;
  cursor: pointer;
}

.svg-buttons > * {
  width: 85px;
  height: 55px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Bouton NON */
.svg-buttons > *:nth-child(1) {
  background-color: #6b3f3f;
}

/* Bouton FAVORI */
.svg-buttons > *:nth-child(2) {
  background-color: #e9edf1;
  border: 2px solid transparent;
}

.svg-buttons > *:nth-child(2):hover {
  border-color: #aaa;
}

/* Bouton OUI */
.svg-buttons > *:nth-child(3) {
  background-color: #3f6868;
}

.pulse {
  animation: pulse 0.6s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }

  50% {
    transform: scale(1.2);
  }

  100% {
    transform: scale(1);
  }
}


.no-more {
  text-align: center;
  font-size: 1.5rem;
  color: #999;
}
</style>
