<script setup lang="ts">
import { onMounted, ref, nextTick } from 'vue'

const carouselRef = ref<HTMLUListElement | null>(null)
const focusedIndex = ref(0)

const scrollBy = (offset: number) => {
  if (carouselRef.value) {
    carouselRef.value.scrollBy({ left: offset, behavior: 'smooth' })
  }
}

const handleScroll = () => {
  if (!carouselRef.value) return

  const items = carouselRef.value.children
  const containerRect = carouselRef.value.getBoundingClientRect()
  let closestIndex = 0
  let closestDistance = Infinity

  Array.from(items).forEach((item, index) => {
    const rect = item.getBoundingClientRect()
    const center = rect.left + rect.width / 2
    const distance = Math.abs(center - (containerRect.left + containerRect.width / 2))

    if (distance < closestDistance) {
      closestDistance = distance
      closestIndex = index
    }
  })

  focusedIndex.value = closestIndex
}

onMounted(async () => {
  await nextTick()
  handleScroll()
  carouselRef.value?.addEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.hide-scrollbar {
  scrollbar-width: none; 
  -ms-overflow-style: none;  
}

.hide-scrollbar::-webkit-scrollbar {
  display: none; 
}

</style>

<template>
  <div class="relative mt-6 px-4 md:px-10">
    <!-- Left Button -->
    <button
      @click="scrollBy(-300)"
      class="hidden md:flex items-center justify-center w-10 h-10 absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-custom-white rounded-full shadow-md hover:bg-white transition"
    >
      ‹
    </button>

    <!-- Carousel -->
    <ul
  ref="carouselRef"
  class="flex gap-4 snap-x snap-mandatory overflow-x-scroll py-6 scroll-smooth hide-scrollbar"
>
  <slot :focused-index="focusedIndex" />
</ul>

    <!-- Right Button -->
    <button
      @click="scrollBy(300)"
      class="hidden md:flex items-center justify-center w-10 h-10 absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-custom-white rounded-full shadow-md hover:bg-white transition"
    >
      ›
    </button>
  </div>
</template>

