<template>
  <div class="favoris-page">


    <main class="main-content">
      <h1 class="text-3xl font-bold mb-6">Mes Favoris</h1>

      <div v-if="favoris.length" class="favoris-list">
        <div v-for="favori in favoris" :key="favori.id" class="favori-card">
          <NuxtLink :to="`/hotel/rooms/${favori.room.id}`" class="card-link">
            <img :src="favori.room.photo_url" alt="Room Image" class="room-image" />
            <div class="info">
              <h2 class="text-xl font-semibold">{{ favori.room.name }}</h2>
              <p class="text-gray-500">{{ favori.room.price_per_night }}€ / nuit</p>
            </div>
          </NuxtLink>
          <button @click="removeFavori(favori.id)" class="btn-remove">Supprimer</button>

        </div>
      </div>

      <div v-else>
        <p>Aucun favori pour l'instant... 💤</p>
      </div>
    </main>
 

  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { api, getLaravelCookie } from '~/lib/api';
import Header from '~/components/layout/Header.vue';
import Footer from '~/components/layout/Footer.vue';

const favoris = ref<any[]>([]);

onMounted(async () => {
  await loadFavoris();
});

async function loadFavoris() {
  try {
    const response = await api.get('api/favoris', {
      headers: {
        "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
      }
    });
    favoris.value = response.data;
  } catch (error) {
    console.error('Erreur en chargeant les favoris:', error);
  }
}

async function removeFavori(favoriId: number) {
  try {
    await api.delete(`api/favoris/${favoriId}`, {
      headers: {
        "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
      }
    });
    favoris.value = favoris.value.filter(f => f.id !== favoriId);
  } catch (error) {
    console.error('Erreur en supprimant le favori:', error);
  }
}
</script>

<style scoped>
.favoris-page {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding: 2rem;
  max-width: 800px;
  margin: 0 auto;
}

.favoris-list {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.favori-card {
  display: flex;
  align-items: center;
  gap: 1rem;
  background: white;
  padding: 1rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.card-link {
  display: flex;
  align-items: center;
  gap: 1rem;
  flex: 1;
  text-decoration: none;
  color: inherit;
}

.room-image {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
}

.info {
  display: flex;
  flex-direction: column;
}

.btn-remove {
  background-color: #e53e3e;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  cursor: pointer;
}
.btn-negocier {
  background-color: #2b6cb0;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  text-align: center;
  text-decoration: none;
}
.btn-negocier:hover {
  background-color: #2c5282;
}
</style>