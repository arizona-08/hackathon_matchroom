<template>
  <div class="swipe-page">


    <main class="main-content">
      <div v-if="currentRoom" class="card-container">
        <CarouselItemSwipe :item="{
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

<script setup lang="ts">import { ref, onMounted } from 'vue';
import { swipe } from '~/lib/swipe';
import { addToFavoris } from '~/lib/favoris'; // 🧡 fonction pour ajouter aux favoris
import { useRouter } from 'vue-router'; // ✅ pour rediriger vers négociation
import CarouselItemSwipe from '~/components/Carousel/CarouselItemSwipe.vue';

const rooms = ref<any[]>([]);
const currentRoom = ref<any | null>(null);
const userId = 1; // À remplacer par l'ID du user connecté
const router = useRouter();
const isFavori = ref(false);

onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/rooms');
    const data = await response.json();
    rooms.value = data.rooms;
    nextRoom();
  } catch (error) {
    console.error('Erreur en chargeant les rooms:', error);
  }
});

function nextRoom() {
  currentRoom.value = rooms.value.shift() || null;
}

function handleSwipe(action: 'pass') {
  swipe(userId, currentRoom, nextRoom, action);
}

async function addToFavorites() {
  if (!currentRoom.value) return;

  try {
    await addToFavoris(currentRoom.value.id);
    triggerPulse(); // Animation ❤️
  } catch (error) {
    console.error('Erreur en ajoutant aux favoris:', error);
  }
}

async function startNego() {
  if (!currentRoom.value) return;

  router.push(`/negociation?room_id=${currentRoom.value.id}`);
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
