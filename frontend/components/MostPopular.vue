<script setup>
import PopularCarousel from './Carousel/PopularCarousel.vue';
</script>

<template>
    <section class="mt-12">
        <h2 class="text-2xl px-4 font-medium">Les plus populaires.</h2>
        <PopularCarousel v-slot="{ focusedIndex }">
            <!-- à garder pour la loop -->
            <!-- <CarouselItem
                v-for="(item, index) in items"
                :key="index"
                :item="item"
                :scale="focusedIndex === index"
            /> -->

            <CarouselItem 
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
                :scale="focusedIndex === 0"
            />

            <CarouselItem 
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

            <CarouselItem 
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