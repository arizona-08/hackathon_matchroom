<script setup lang="ts">
import { onMounted, ref, nextTick, reactive, watch } from 'vue'

const carouselRef = ref<HTMLUListElement | null>(null)
const focusedIndex = ref(0) // 👈 start at the 2nd item

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

    const carousel = carouselRef.value

    carousel?.addEventListener('scroll', handleScroll)
})
</script>

<template>
    <div class="mt-6 px-4">
        <ul ref="carouselRef" class="flex gap-4 snap-x snap-mandatory overflow-x-scroll py-6">
            <slot :focused-index="focusedIndex"/>
        </ul>
    </div>
</template>