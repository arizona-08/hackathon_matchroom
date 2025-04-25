<script setup lang="ts">
import BurergerMenu from '../BurergerMenu.vue'
import Milescount from '../Milescount.vue'
import ProfileMenu from '../ProfileMenu.vue'
import { useRoute } from 'vue-router'

const route = useRoute()
</script>

<template>
  <nav class="px-4 flex">
    <div class="flex justify-between items-center w-full">
      <div class="logo-container">
        <img src="/img/svgs/logo.svg" alt="">
      </div>
      <div class="hidden md:flex items-center gap-20 text-black font-medium text-xl">
        <NuxtLink to="/filtre/search" :class="{ 'text-primary font-semibold': route.path.includes('/filtres') }">Filtres</NuxtLink>
        <NuxtLink to="/match" :class="{ 'text-primary font-medium': route.path.includes('/match') }">Match</NuxtLink>
        <NuxtLink to="/" :class="{ 'text-primary font-semibold': route.path.includes('/annonces') }">Annonces</NuxtLink>
        <NuxtLink to="/interactive-map" :class="{ 'text-primary font-semibold': route.path.includes('/plan') }">Plan</NuxtLink>
        <NuxtLink to="/negociation" :class="{ 'text-primary font-semibold': route.path.includes('/chats') }">Chat</NuxtLink>
      </div>
      <div>
        <div class="flex items-center gap-1">
          <Milescount/>
          <ProfileMenu/>
        </div>
      </div>
    </div>
  </nav>
</template>