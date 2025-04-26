<script setup lang="ts">
interface CarouselItemType{
    title: string
    address: string
    city: string
    price: number
    capacity: number
    stars: number
    tags: string[]
    img: string
    link: string
}

const {item} = defineProps<{
    item: CarouselItemType
    scale: boolean
}>();
</script>

<template>
    <li 
        class="snap-center transition-transform duration-300 ease-in-out w-82 h-54 shrink-0 rounded-2xl overflow-hidden relative md:w-6/12 lg:w-4/12 2xl:w-3/12"
        :class="scale ? 'scale-100 z-10' : 'scale-95 opacity-80'"
    
    >
        <NuxtLink :to="item.link" class="block relative w-full h-full">
            <div class="w-full h-full">
                <div class="w-full h-full">
                    <NuxtImg :src="item.img" alt="" class="w-full h-full object-cover"/>
                </div>

                <div class="layer bg-linear-to-t from-black/80 to-black/0 absolute top-0 left-0 w-full h-full"></div>

                <div class="infos text-white absolute bottom-0 px-2 py-2 w-full">
                    <div class="flex justify-between items-center mb-4">
                        <div class="head mb-1">
                            <div class="stars flex gap-0.5">
                                <div class="star-container w-2 h-2 mb-1" v-for="i in item.stars" :key="i">
                                    <NuxtImg src="/img/svgs/Etoile_Jaune.svg" alt="" srcset=""/>
                                </div>
                            </div>
                            <p class="text-xl font-semibold">{{ item.title }}</p>
                            <p class="text-xs">{{ item.address }} - {{ item.city }}</p>
                        </div>

                        <div class="mt-4">
                            <div>
                                <p class="text-xs">{{ item.price }} /nuits</p>
                                <p class="text-xs">{{ item.capaxcity }} personnes</p>
                            </div>
                        </div>
                    </div>

                    <div class="tags flex gap-1">
                        <span v-for="tag in item.tags" :key="tag" class="bg-primary text-white rounded-full px-2 py-1 text-[10px]">{{ tag }}</span>
                    </div>
                </div>
            </div>

        </NuxtLink>
        
    </li>
</template>