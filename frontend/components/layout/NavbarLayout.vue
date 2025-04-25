<script setup lang="ts">
import BurergerMenu from '../BurergerMenu.vue';
import Milescount from '../Milescount.vue';
import ProfileMenu from '../ProfileMenu.vue';

</script>

<template>
  <nav class="px-4 flex">
    <div class="flex justify-between items-center w-full">
      <NuxtLink to="/">
        <div class="logo-container">
          <img src="/img/svgs/logo.svg" alt="">
        </div>
      </NuxtLink>
      
      <div>
        <div class="flex items-center gap-1">
          <Milescount/>
          <ProfileMenu/>
        </div>

      </div>
    </div>

    
  </nav>
</template>