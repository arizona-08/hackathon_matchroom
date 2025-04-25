<script setup>
import Carrousel from '../components/Carrousel.vue';
import Header  from '../components/layout/Header.vue';
import HeroSection from '../components/layout/HeroSection.vue';
import Footer from '../components/layout/Footer.vue';
import SimpleAutoSlider from '../components/SimpleAutoSlider.vue';
import BonPlansCarousel from '../components/BonPlansCarousel.vue';

</script>

<template>
  <div class="container mx-auto px-4">
    <Header />
    <HeroSection />
    <Carrousel />
    <BonPlansCarousel />

  </div>



  <Footer />
</template>

<style scoped>
.container {
  max-width: 1728px;
}
</style>