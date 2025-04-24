<script setup>
import { getAllRooms } from '~/lib/room';

const rooms = ref([]);

async function fetchRooms(){
    const response = await getAllRooms();
    if(response.status === 200){
        rooms.value = response.data.rooms;
        console.log("Chambres récupérées avec succès", response.data);
        // Traitez les données des chambres ici
    } else {
        console.error("Erreur lors de la récupération des chambres", response);
    }
}

onMounted(() => {
    fetchRooms();
});
</script>

<template>
    <h1>hello</h1>
    <div v-for="(room, index) in rooms" :key="index">
      <!-- Render your room here -->
      <h3>{{ room.name }}</h3>
      <p>{{ room.description }}</p>
      <img :src="room.photo_url" alt="" class="rounded-full w-32 h-32 object-cover">
    </div>
</template>