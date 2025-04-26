<script setup lang="ts">
import RoomImages from '~/components/Carousel/RoomImages.vue'; // 🔥 import
interface CarouselItemType {
  title: string
  address: string
  city: string
  price: number
  capacity: number
  stars: number
  tags: string[]
  img: string
  link: string
  images?: string[] // images supplémentaires pour le slider
}

const { item } = defineProps<{
  item: CarouselItemType
  scale: boolean
}>();
</script>

<template>
  <li
    class="snap-center transition-transform duration-300 ease-in-out w-74 h-96 shrink-0 rounded-2xl overflow-hidden relative"
    :class="scale ? 'scale-100 z-10' : 'scale-95 opacity-80'"
  >
    <NuxtLink :to="item.link" class="block relative w-full h-full">
      <RoomImages :images="item.images?.length ? item.images : [item.img]" />

      <div class="layer bg-gradient-to-t from-black/80 to-black/0 absolute top-0 left-0 w-full h-full"></div>

      <div class="infos text-white absolute bottom-0 px-2 py-2 w-full">
        <div class="head mb-2">
          <div class="stars flex gap-0.5">
            <div class="star-container w-2 h-2 mb-1" v-for="i in item.stars" :key="i">
              <NuxtImg src="/img/svgs/Etoile_Jaune.svg" alt="" />
            </div>
          </div>
          <p class="text-3xl font-semibold">{{ item.title }}</p>
        </div>
        
        <div class="mb-6 font-medium">
          <p>{{ item.address }} - {{ item.city }}</p>
          <p>{{ item.price }}€ / nuit</p>
          <p>{{ item.capacity }} personnes</p>
        </div>
        
        <div class="tags flex gap-1">
          <span v-for="tag in item.tags" :key="tag" class="bg-primary text-white rounded-full px-2 py-1 text-[10px]">{{ tag }}</span>
        </div>
      </div>
    </NuxtLink>
  </li>
</template>
