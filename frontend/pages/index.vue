<script setup>
import Carrousel from '../components/Carrousel.vue';
import Header  from '../components/layout/Header.vue';
import HeroSection from '../components/layout/HeroSection.vue';
import Footer from '../components/layout/Footer.vue';
import SimpleAutoSlider from '../components/SimpleAutoSlider.vue';

</script>

<template>
  <div class="container mx-auto px-4">
    <Header />
    <HeroSection />
    <h1 class="text-3xl font-bold mb-6">Les plus populaires.</h1>
    <Carrousel />
    <h1 class="text-3xl font-bold mb-6">Bon Plan</h1>
    <Carrousel />

  </div>



  <Footer />
</template>

<style scoped>
.container {
  max-width: 1728px;
}
</style>