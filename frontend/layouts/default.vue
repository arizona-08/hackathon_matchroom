<script setup>
import NavbarLayout from '~/components/layout/NavbarLayout.vue';
import FooterLayout from '~/components/layout/FooterLayout.vue';

</script>

<template>
    <div class="flex flex-col min-h-screen">
        <NavbarLayout/>
        <main class="flex-grow">
            <slot/>
        </main>
        <FooterLayout/>
    </div>
    
</template>