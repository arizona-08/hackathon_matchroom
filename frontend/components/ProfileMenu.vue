<script setup>
import BurergerMenu from './BurergerMenu.vue';

const isOpen = ref(false);

function handleClick(){
    isOpen.value = !isOpen.value;
}

</script>

<template>
    <div class="flex justify-between items-center py-2 cursor-pointer" :onClick="handleClick">
        <div class="relative border border-primary rounded-full px-2 py-1 flex gap-2 items-center">
            <BurergerMenu/>
            <div class="text-white bg-primary w-6 h-6 rounded-full flex items-center justify-center">
                <span class="inline-block text-sm">M</span>
            </div>

            <ul :class="{'hidden': !isOpen, 'block': isOpen}" class="absolute z-20 top-full right-0 bg-primary text-white min-w-40 mt-2 py-1 rounded-tl-2xl rounded-bl-2xl rounded-br-2xl">
                <div class="space-y-1 mb-2 px-3">
                    <li>Se connecter</li>
                    <li>Se connecter</li>
                </div>
                <hr>
                <div class="space-y-1 mt-2 px-3">
                    <li>Parrainage</li>
                    <li>Centre d'aide</li>
                </div>
            </ul>
        </div>
    </div>
</template>