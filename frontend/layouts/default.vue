<script setup>
import NavbarLayout from '~/components/layout/NavbarLayout.vue';
import FooterLayout from '~/components/layout/FooterLayout.vue';

</script>

<template>
    <div>
        <NavbarLayout/>
        <slot/>
        <FooterLayout/>
    </div>
    
</template>