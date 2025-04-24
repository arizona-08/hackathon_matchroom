<template>
    <nav class="bg-gray-800 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <router-link to="/" class="text-xl font-bold">MatchRoom</router-link>
        
        <div class="flex items-center space-x-6">
          <router-link to="/" class="hover:text-gray-300">Accueil</router-link>
          <router-link to="/search" class="hover:text-gray-300">Recherche</router-link>
          <router-link to="/my-reservations" class="hover:text-gray-300">Mes Réservations</router-link>
          
          <div v-if="isLoggedIn">
            <span>{{ user?.name }}</span>
            <button @click="logout" class="ml-4 bg-red-600 px-3 py-1 rounded hover:bg-red-700">
              Déconnexion
            </button>
          </div>
          <div v-else>
            <router-link to="/login" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
              Connexion
            </router-link>
          </div>
        </div>
      </div>
    </nav>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import axios from 'axios';
  
  const router = useRouter();
  const isLoggedIn = ref(false);
  const user = ref(null);
  
  async function checkAuth() {
    try {
      const response = await axios.get('/api/user');
      if (response.data) {
        isLoggedIn.value = true;
        user.value = response.data;
      }
    } catch (error) {
      isLoggedIn.value = false;
      user.value = null;
    }
  }
  
  async function logout() {
    try {
      await axios.post('/api/logout');
      isLoggedIn.value = false;
      user.value = null;
      router.push('/login');
    } catch (error) {
      console.error('Erreur lors de la déconnexion:', error);
    }
  }
  
  onMounted(() => {
    checkAuth();
  });
  </script>