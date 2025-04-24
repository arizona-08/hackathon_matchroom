<template>
    <div class="relative w-[108rem] h-[154.75rem] overflow-hidden mx-auto">
      <!-- Images d'arrière-plan -->
      <img
        v-for="(image, index) in backImages"
        :key="'back' + index"
        :src="image"
        class="absolute opacity-30 w-[40.06rem] h-[23.69rem] object-cover rounded-xl"
        :class="{
          'left-[-1.56rem] top-[58.44rem]': index % 2 === 0,
          'left-[75.25rem] top-[58.44rem]': index % 2 === 1
        }"
      />
  
      <!-- Image gauche -->
      <img
        :src="images[prevIndex]"
        class="absolute w-[65.38rem] h-[38.63rem] object-cover rounded-xl top-[51rem] left-[-54.63rem]"
      />
  
      <!-- Image droite -->
      <img
        :src="images[nextIndex]"
        class="absolute w-[65.38rem] h-[38.63rem] object-cover rounded-xl top-[51rem] left-[97.13rem]"
      />
  
      <!-- Image principale avec texte -->
      <div class="absolute top-[49.38rem] left-[18.19rem] w-[71.63rem] h-[41.81rem] rounded-2xl overflow-hidden shadow-lg">
        <img
          :src="images[currentIndex]"
          class="w-full h-full object-cover"
        />
  
        <!-- Texte en overlay -->
        <div class="absolute inset-0 z-10 text-white font-redhat">
          <h2 class="absolute text-[3rem] font-bold leading-none left-[21.5rem] top-[79.44rem]">Hotel Cayenne</h2>
          <div class="absolute text-[0.875rem] tracking-widest left-[48.88rem] top-[82.31rem]">★★★★★</div>
          <div class="absolute text-[1.25rem] left-[21.5rem] top-[84.38rem]">20 rue du canard - Nice</div>
          <div class="absolute text-[1.125rem] opacity-80 left-[21.5rem] top-[88.88rem]">
            Piscine - Pricing - Bar - Climatisation - Chauffage
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
  
  const images = ref([
    '/img/bg.jpg',
    '/img/bg1.jpg',
    '/img/bg.jpg',
    '/img/bg1.jpg',
  ])
  
  const backImages = ref([
    '/img/bg.jpg',
    '/img/bg1.jpg',
  ])
  
  const currentIndex = ref(0)
  let interval = null
  
  const prevIndex = computed(() => (currentIndex.value - 1 + images.value.length) % images.value.length)
  const nextIndex = computed(() => (currentIndex.value + 1) % images.value.length)
  
  onMounted(() => {
    interval = setInterval(() => {
      currentIndex.value = (currentIndex.value + 1) % images.value.length
    }, 4000)
  })
  
  onBeforeUnmount(() => {
    clearInterval(interval)
  })
  </script>
  
  <style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;700&display=swap');
  
  .font-redhat {
    font-family: 'Red Hat Display', sans-serif;
  }
  </style>
  