<script setup>
    defineProps({
        link: {
            type: String,
            required: true
        }
    })
</script>

<template>
    <NuxtLink :to="link" class="bg-primary rounded-tr-md rounded-br-md rounded-bl-md text-white px-4 py-1">
        <slot />
    </NuxtLink>
</template>