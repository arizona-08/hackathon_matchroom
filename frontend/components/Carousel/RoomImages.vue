<script setup>
import { ref } from 'vue';

const props = defineProps({
  images: {
    type: Array,
    required: true,
    default: () => []
  }
});

const currentIndex = ref(0);

function nextImage() {
  currentIndex.value = (currentIndex.value + 1) % props.images.length;
}

function prevImage() {
  currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length;
}
</script>

<template>
  <div class="relative w-full h-64 overflow-hidden rounded-2xl shadow-md">
    <img
      :src="images[currentIndex]"
      class="w-full h-full object-cover transition-transform duration-500"
      alt="room image"
    />

  
   
  </div>
</template>

<style scoped>
</style>
