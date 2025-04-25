<script setup>
import { getUserFilters } from '~/lib/search';
import BurergerMenu from './BurergerMenu.vue';
import { getAuthUser } from '~/lib/user';
import CarouselItem from './Carousel/CarouselItem.vue';
import { logout } from '~/lib/auth';

const isOpen = ref(false);
const user = ref(null);
const router = useRouter();

function handleClick(){
    isOpen.value = !isOpen.value;
}

async function fetchUser(){
    const response = await getAuthUser();
    if (response.status === 200) {
        user.value = await response.data;
        // console.log(user);
    } else {
        console.error('Error fetching user data:', response);
    }
}

async function handleLogout(){
    const response = await logout();
    if (response.status === 200) {
        user.value = null;
        console.log('User logged out successfully');
        router.push('/');
    } else {
        console.error('Error logging out:', response);
    }
}

onMounted(() => {
    fetchUser();
})

</script>

<template>
    <div class="flex justify-between items-center py-2 cursor-pointer" :onClick="handleClick">
        <div class="relative border border-primary rounded-full px-2 py-1 flex gap-2 items-center">
            <BurergerMenu/>
            <div class="text-white bg-primary w-6 h-6 rounded-full flex items-center justify-center">
                <span class="inline-block text-sm">M</span>
            </div>

            <ul :class="{'hidden': !isOpen, 'block': isOpen}" class="absolute z-20 top-full right-0 bg-primary text-white min-w-40 mt-2 py-1 rounded-tl-2xl rounded-bl-2xl rounded-br-2xl">
                <div class="space-y-1 mt-2 mb-2 px-3" v-if="user != null">
                    <div >
                        <li><NuxtLink to="/profil">Compte</NuxtLink></li>
                        <li><NuxtLink to="/favorites">Favoris</NuxtLink></li>
                    </div>
                </div>

                <div v-else="user == null" >
                    
                    <div class="space-y-1 mt-2 mb-2 px-3">
                        <li><NuxtLink to="/auth/login">Se connecter</NuxtLink></li>
                        <li><NuxtLink to="/auth/register">S'inscrire</NuxtLink></li>
                    </div>
                    <hr class="text-soft-green">
                    <div class="space-y-1 mt-2 mb-2 px-3">
                        <li><NuxtLink to="/help">Centre d'aide</NuxtLink></li>
                        <li><NuxtLink to="/parrainage">Parrainage</NuxtLink></li>
                    </div>
                </div>
                
                <div class="space-y-1 mt-2 mb-2 px-3">
                    <div v-if="user && user.role == 'voyageur'">
                        <hr class="text-soft-green">
                        <li><NuxtLink to="/filtres">Filtres</NuxtLink></li>
                        <li><NuxtLink to="/match">Matchs</NuxtLink></li>
                        <li><NuxtLink to="/annonces">Annonce</NuxtLink></li>
                        <li><NuxtLink to="/interactive-map">Plan</NuxtLink></li>
                        <li><NuxtLink to="/negotiations">Chat</NuxtLink></li>
                        <li><NuxtLink to="/reservations">Réservations</NuxtLink></li>
                        <li><NuxtLink to="/avantages">Mes avantages</NuxtLink></li>
                        <li><NuxtLink to="/parrainage">Parrainage</NuxtLink></li>
                    </div>
                    <div v-if="user && user.role == 'hotelier'">
                        <hr class="text-soft-green">
                        <li><NuxtLink to="`/hotel/${user.hotel.id}`">Mon hôtel</NuxtLink></li>
                    </div>
                    
                </div>
                
                <div v-if="user != null" class="space-y-1 mt-2 mb-2 px-3">
                    <hr class="text-soft-green">
                    <li><NuxtLink to="/help">Centre d'aide</NuxtLink></li>
                    <button v-if="user != null" :onClick="handleLogout">Me déconnecter</button>
                </div>
            </ul>
        </div>
    </div>
</template>