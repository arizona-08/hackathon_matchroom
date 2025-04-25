<script setup>
import { getAllRooms } from '~/lib/room';
import PopularCarousel from './Carousel/PopularCarousel.vue';
import SmallCarouselItem from './Carousel/SmallCarouselItem.vue';

const allRooms = ref([]);

async function fetchRooms(){
    const response = await getAllRooms();
    if (response.status === 200) {
        allRooms.value = response.data.rooms;
        // console.log(allRooms.value);
        // console.log(hasRooms.value);
    } else {
        console.error('Error fetching rooms:', response);
    }
}

const hasRooms = computed(() => allRooms.value.length > 0);

onMounted(async () => {
    await fetchRooms();
})
</script>

<template>
    <section class="mt-12">
        <h2 class="text-2xl px-4 font-medium md:px-10">Bon plans.</h2>
         <!-- <SmallCarouselItem
                v-for="(item, index) in items"
                :key="index"
                :item="item"
                :scale="focusedIndex === index"
            /> -->
        <PopularCarousel v-slot="{ focusedIndex }">
            
            <SmallCarouselItem
            v-for="(room, index) in allRooms"
                :key="index"
                :item="{
                    img: room.photo_url,
                    title: room.hotel.name,
                    address: room.hotel.address,
                    city: room.hotel.city,
                    price: room.price_per_night,
                    stars: room.hotel.number_of_stars,
                    capacity: room.capacity,
                    tags: room.equipement,
                    link: '/hotel/rooms/' + room.id
                }"
                :scale="focusedIndex === index"
            />

        </PopularCarousel>
    </section>
    
    
</template>