<template>
    <button class="flex items-center justify-center gap-3 w-full border border-black py-3 rounded-lg hover:bg-gray-100 transition">
      <img :src="icon" alt="icon" class="w-6 h-6" />
      <span class="text-sm font-medium text-black">{{ text }}</span>
    </button>
  </template>
  
  <script setup>
  defineProps({
    icon: String,
    text: String
  })
  </script>
  