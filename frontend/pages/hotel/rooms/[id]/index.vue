<script setup>
import CarouselItem from '~/components/Carousel/CarouselItem.vue';
import { getRoom, getSameHotelRoom } from '~/lib/room';

const room = ref(null);
const sameHotelRooms = ref([]);

const route = useRoute()

const room_id = route.params.id;

async function fetchRoom(){
    const response = await getRoom(room_id);
    if(response.status === 200){
        room.value = response.data.room;
        console.log("Chambre récupérée avec succès", room.value);
        // Traitez les données des chambres ici
    } else {
        console.error("Erreur lors de la récupération de la chambre", response);
    }
}

async function fetchSameHotelRooms(){
    const hotel_id = room.value.hotel.id;
    const response = await getSameHotelRoom(hotel_id);
    if(response.status === 200){
        sameHotelRooms.value = response.data.rooms;
        console.log("Chambre récupérée avec succès", sameHotelRooms.value);
        // Traitez les données des chambres ici
    } else {
        console.error("Erreur lors de la récupération de la chambre", response);
    }
}

const hasRoom = computed(() => room.value !== null);
const hasSameHotelRooms = computed(() => sameHotelRooms.value.length > 0);

onMounted( async () => {
    await fetchRoom();
    await fetchSameHotelRooms()
});

</script>

<template>
    <template v-if="hasRoom">
        <section class="relative w-screen h-screen">
            <div class="img-container w-full h-full">
                <img :src="room.photo_url" alt="Room Image" class="w-full h-full object-cover">
            </div>
            <div class="layer bg-linear-to-t from-black/80 to-black/0 absolute top-0 left-0 w-full h-full"></div>

            <div class="infos text-white absolute bottom-0 px-4 py-4 w-full">
                <div class="head mb-2 flex items-center gap-4">
                    <h1 class="text-3xl font-semibold">{{ room.hotel.name }}</h1>
                    <div class="stars flex gap-1">
                        <div class="star-container w-4 h-4 mb-1" v-for="i in room.hotel.number_of_stars" :key="i">
                            <NuxtImg src="/img/svgs/Etoile_Jaune.svg" alt="" srcset=""/>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6 space-y-2">
                    <p>{{ room.hotel.address }} - {{ room.hotel.city }}</p>
                    <div>
                        <p>{{ room.price_per_night }}€ /nuits</p>
                        <p>{{ room.capacity }} personnes</p>
                    </div>
                    
                </div>
                
                <div class="tags flex gap-1">
                    <span v-for="tag in room.equipment" :key="tag" class="bg-primary text-white rounded-full px-2 py-1 text-[10px]">{{ tag }}</span>
                </div>
            </div>
        </section>

        <section class="px-4 mt-8">
            <div class="actions space-x-4 mb-4">
                <CTA :link="`/negociation?room_id=${room.id}`">
                    Négocier !
                </CTA>

                <CTA :link="`/reservation?room_id=${room.id}`">
                    Réserver !
                </CTA>
            </div>


            <div class="mb-4">
                <h3 class="text-xl mb-2">Description:</h3>
                <p>{{ room.description }}</p>
            </div>

            <div>
                <NuxtLink :to="`/hotel/${room.hotel.id}`" class="text-primary underline">
                    Écrire un avis
                </NuxtLink>

                <ul class="flex gap-4 mt-4">
                    <li>
                        <div class="border border-primary rounded-tr-lg rounded-br-lg rounded-bl-lg px-4 py-4">
                            <div class="flex items-center gap-4 mb-2">
                                <span class="inline-block w-4 h-4 bg-black rounded-full"></span>
                                <p class="text-xs">Jean-Luc a écrit un avis en mars 2025</p>
                            </div>

                            <div class="flex items-center gap-2 mb-2">
                                <div class="img-container w-4 h-4">
                                    <NuxtImg src="/svg/Etoile_Transparent.svg" alt=""/>
                                </div>
                                
                                <p class="text-xs">4.5</p>
                            </div>

                            <p class="text-md font-semibold mb-2">Très bel hôtel </p>
                            <p class="mb-2 text-xs">Hôtel très bien situé pour se rendre à la plage et au centre ville de Dinard. Nous étions dans une chambre spacieuse, comfortable et très bien équipée, avec d'un côté, la vue ...</p>
                            <p class="underline">Voir plus</p>

                            

                        </div>
                    </li>
                </ul>
            </div>
            
        </section>

        <section class="px-4 mt-8" v-if="hasSameHotelRooms">
            <h2 class="mb-6 font-semibold">Dans le même hôtel.</h2>

            <div class="overflow-x-auto">
                <ul>
                    <li v-for="sameRoom in sameHotelRooms" :key="sameRoom.id" class="snap-center transition-transform duration-300 ease-in-out w-82 h-54 shrink-0 rounded-2xl overflow-hidden relative md:w-6/12 lg:w-4/12 2xl:w-3/12">
                        <NuxtLink :to="`/hotel/room/${sameRoom.id}`" class="block relative w-full h-full">
                            <div class="w-full h-full">
                                <div class="w-full h-full">
                                    <NuxtImg :src="sameRoom.photo_url" alt="" class="w-full h-full object-cover"/>
                                </div>

                                <div class="layer bg-linear-to-t from-black/80 to-black/0 absolute top-0 left-0 w-full h-full"></div>

                                <div class="infos text-white absolute bottom-0 px-2 py-2 w-full">
                                    <div class="flex justify-between items-center mb-4">
                                        <div class="head mb-1">
                                            <div class="stars flex gap-0.5">
                                                <div class="star-container w-2 h-2 mb-1" v-for="i in sameRoom.hotel.numnber_of_stars" :key="i">
                                                    <NuxtImg src="/img/svgs/Etoile_Jaune.svg" alt="" srcset=""/>
                                                </div>
                                            </div>
                                            <p class="text-xl font-semibold">{{ sameRoom.hotel.name }}</p>
                                            <p class="text-xs">{{ sameRoom.hotel.address }} - {{ sameRoom.hotel.city }}</p>
                                        </div>

                                        <div class="mt-4">
                                            <div>
                                                <p class="text-xs">{{ sameRoom.price_per_night }}€ /nuits</p>
                                                <p class="text-xs">{{ sameRoom.capaxcity }} personnes</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tags flex gap-1">
                                        <span v-for="tag in sameRoom.equipment" :key="tag" class="bg-primary text-white rounded-full px-2 py-1 text-[10px]">{{ tag }}</span>
                                    </div>
                                </div>
                            </div>

                        </NuxtLink>
                        
                    </li>
                </ul>
            </div>
        </section>
    </template>
    <template v-else>
        <p class="text-center text-gray-500">Aucun résultat trouvé.</p>
    </template>

</template>