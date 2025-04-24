<script setup>
import { getRoom } from '~/lib/room';

const room = ref([]);

const route = useRoute()

const room_id = route.params.id;

async function fetchRoom(){
    const response = await getRoom(room_id);
    if(response.status === 200){
        room.value = response.data.room;
        console.log("Chambre récupérée avec succès", response.data);
        // Traitez les données des chambres ici
    } else {
        console.error("Erreur lors de la récupération de la chambre", response);
    }
}

onMounted(() => {
    fetchRoom();
});

</script>

<template>
<h1>hello</h1>
<div>
    <h3>{{ room.name }}</h3>
    <p>{{ room.description }}</p>
    <img :src=room.photo_url alt="">
</div>
</template>