<script setup>
import { reactive } from 'vue';
import { updateRoomWithPic, getRoom, updateRoom } from '~/lib/room';
const room = reactive({
    name: '',
    description: '',
    price_per_night: '',
    type: '',
    capacity: '',
    available_from: '',
    available_to: '',
    negotiation_max_discount: '',
    negotiation_auto_accept_threshold: '',
    photo_path: '',
    number_of_beds: '',
    // equipment: '',
    // score_matching: ''
})

async function handlePicSubmit(){
    const formData = new FormData();

    for (const key in room) {
        formData.append(key, room[key]);
    }
    const response = await updateRoomWithPic(formData, room_id);
    console.log(response);
    if(response.status === 201){
        console.log("Chambre modifiée avec succès");
        // Redirection ou autre action après la création
    } else {
        console.error("Erreur lors de la modification de la chambre", response);
    }
}

async function submitRoom(){
    const response = await updateRoom(room, room_id);
    console.log(response);
    if(response.status === 201){
        console.log("Chambre modifiée avec succès");
        // Redirection ou autre action après la création
    } else {
        console.error("Erreur lors de la modification de la chambre", response);
    }
}

function handleChange(event){
    room.photo_path = event.target.files[0];
}

const route = useRoute();
const room_id = route.params.id;


function formatDate(dateStr) {
  const date = new Date(dateStr)
  return date.toISOString().split('T')[0] // "yyyy-MM-dd"
}

async function fetchRoom(){
    const response = await getRoom(room_id);
    if(response.status === 200){
        const data = response.data.room;
        Object.assign(room,{
            ...response.data.room,
            available_from: formatDate(response.data.room.available_from),
            available_to: formatDate(response.data.room.available_to),
        });
        console.log("Chambre récupérée avec succès", data);
    } else {
        console.error("Erreur lors de la récupération de la chambre", response);
    }
}

onMounted(() => {
    fetchRoom();
});


</script>

<template>
    <form method="POST" class="space-y-12" @submit.prevent="submitRoom">
        <div>
            <div class="flex justify-around m-auto max-w-5xl">
                <div class="left flex flex-col gap-2">
                    <div class="flex flex-col gap-1 max-w-86">
                        <label for="name">Nom de la chambre</label>
                        <input class="border" type="text" id="name" name="name" placeholder="Entrez le nom de la chambre" required v-model="room.name">
                    </div>

                    <div class="flex flex-col gap-1 max-w-86">
                        <label for="description">Description</label>
                        <textarea class="border" id="description" name="description" placeholder="Entrez la description de la chambre" required v-model="room.description"></textarea>
                    </div>

                    <div class="flex flex-col gap-1 max-w-86">
                        <label for="price">Prix</label>
                        <input class="border" type="number" id="price" name="price" placeholder="Entrez le prix de la chambre" required v-model="room.price_per_night">
                    </div>

                    <div class="flex flex-col gap-1 max-w-86">
                        <label for="price">Capacité max</label>
                        <input class="border" type="number" id="price" name="price" placeholder="Entrez la capacité de la chambre" required v-model="room.capacity">
                    </div>

                    <div class="flex flex-col gap-1 max-w-86">
                        <label for="number_of_beds">Nombre de lits</label>
                        <input class="border" type="number" id="number_of_beds" name="number_of_beds" placeholder="Entrez le nombre de lit" required v-model="room.number_of_beds">
                    </div>
                </div>

                <div class="right flex flex-col gap-2">
                    

                    <div class="flex flex-col gap-1 max-w-86">
                        <p>Disponibilité</p>
                        <label for="available_from">Debut:</label>
                        <input class="border" type="date" id="available_from" name="available_from" required v-model="room.available_from">

                        <label for="available_to">fin:</label>
                        <input class="border" type="date" id="available_to" name="available_to" required v-model="room.available_to">
                    </div>

                    <div class="flex flex-col gap-1 max-w-86">
                        <p>Seuils:</p>

                        <label for="negotiation_auto_accept_threshold">Seuil d'acceptation</label>
                        <input class="border" type="number" id="negotiation_auto_accept_threshold" name="negotiation_auto_accept_threshold" placeholder="Entrez la capacité de la chambre" required v-model="room.negotiation_auto_accept_threshold">

                        <label for="negotiation_max_discount">Seuil de refus automatique</label>
                        <input class="border" type="number" id="negotiation_max_discount" name="negotiation_max_discount" placeholder="Entrez la capacité de la chambre" required v-model="room.negotiation_max_discount">
                    </div>
                </div>
            </div>
            
        </div>
        <button type="submit" class="bg-blue-500 px-2 py-1">modifier</button>
    </form>


    <form @submit.preview="handlePicSubmit">
        <div class="flex flex-col gap-1 max-w-86">
            <label for="room_photo">Choisir une image</label>
            <input @change="handleChange" type="file" name="photo_path" id="photo_path">
        </div>
        <button type="submit" class="bg-blue-500 px-2 py-1">modifier</button>
    </form>
</template>