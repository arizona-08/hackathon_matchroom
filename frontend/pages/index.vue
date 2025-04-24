<script setup>
import Carrousel from '../components/Carrousel.vue';
</script>

<template>
  <div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Les plus populaires.</h1>
    <Carrousel />
  </div>
</template>

<style scoped>
.container {
  max-width: 1728px;
}
</style>