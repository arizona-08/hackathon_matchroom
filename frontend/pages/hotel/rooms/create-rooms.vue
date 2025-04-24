<script setup>
import { reactive } from 'vue';
import { createRoom } from '~/lib/room';
const room = reactive({
    name: '',
    description: '',
    price: '',
    type: '',
    capacity: '',
    available_from: '',
    available_to: '',
    negotiation_max_discount: '',
    negotiation_auto_accept_threshold: ''
    // equipment: '',
    // score_matching: ''
})

async function submitRoom(){
    const response = await createRoom(room);
    console.log(response);
    if(response.status === 201){
        console.log("Chambre créée avec succès");
        // Redirection ou autre action après la création
    } else {
        console.error("Erreur lors de la création de la chambre", response);
    }
}
</script>

<template>
    <form method="POST" class="m-auto flex flex-col gap-2 max-w-86" @submit.prevent="submitRoom">
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
            <input class="border" type="number" id="price" name="price" placeholder="Entrez le prix de la chambre" required v-model="room.price">
        </div>

        <div class="flex flex-col gap-1 max-w-86">
            <label for="price">Capacité max</label>
            <input class="border" type="number" id="price" name="price" placeholder="Entrez la capacité de la chambre" required v-model="room.capacity">
        </div>

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

        <button type="submit" class="bg-blue-500 px-2 py-1">Créer</button>
    </form>
</template>