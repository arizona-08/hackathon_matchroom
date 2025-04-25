<script setup>
import PopularCarousel from './Carousel/PopularCarousel.vue';
import SmallCarouselItem from './Carousel/SmallCarouselItem.vue';
</script>

<template>
    <section class="mt-12">
        <h2 class="text-2xl px-4 font-medium">Bon plans.</h2>
         <!-- <SmallCarouselItem
                v-for="(item, index) in items"
                :key="index"
                :item="item"
                :scale="focusedIndex === index"
            /> -->
        <PopularCarousel v-slot="{ focusedIndex }">
            
            <SmallCarouselItem
                :item="{
                    img: '/img/pngs_jpgs/chambre_hotel.png',
                    title: 'Hotel Matchroom',
                    address: '12 rue du Soleil',
                    city: 'Paris',
                    price: 180,
                    stars: 5,
                    capaxcity: 4,
                    tags: ['Wi-Fi', 'Piscine', 'Climatisation'],
                    link: '/hotel/rooms/2'
                }"
                :scale="focusedIndex === 0"
            />

            <SmallCarouselItem
                :item="{
                    img: '/img/pngs_jpgs/chambre_hotel.png',
                    title: 'Hotel Matchroom',
                    address: '12 rue du Soleil',
                    city: 'Paris',
                    price: 180,
                    stars: 5,
                    capaxcity: 4,
                    tags: ['Wi-Fi', 'Piscine', 'Climatisation']
                }"
                :scale="focusedIndex === 1"
            />

            <SmallCarouselItem 
                :item="{
                    img: '/img/pngs_jpgs/chambre_hotel.png',
                    title: 'Hotel Matchroom',
                    address: '12 rue du Soleil',
                    city: 'Paris',
                    price: 180,
                    stars: 5,
                    capaxcity: 4,
                    tags: ['Wi-Fi', 'Piscine', 'Climatisation']
                }"
                :scale="focusedIndex === 2"
            />
        </PopularCarousel>
    </section>
    
    
</template>