<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-custom-white bg-opacity-40 backdrop-bl-sm border border-soft-green">
    <div class="overflow-y-auto hide-scrollbar bg-custom-white border-3 border-soft-green shadow-lg p-6 w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-tr-lg rounded-br-lg rounded-bl-lg scrollbar-thin scrollbar-thumb-primary scrollbar-track-custom-white">
  <div class="flex justify-end mb-2">
    <button @click="closeModal" class="text-black text-xl font-bold">&times;</button>
  </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>

          <label class="block text-lg font-medium text-black mb-1">Destination..</label>
          <input v-model="trip.city" type="text" placeholder="Destination"
            class="w-full px-4 py-2 rounded-tr-md rounded-br-md rounded-bl-md border border-soft-green bg-custom-white placeholder-gray-400 focus:ring-2 focus:ring-soft-green focus:outline-none" />
        </div>

        <div>
          <label class="block text-lg font-semibold text-black mb-1">Dates..</label>
          <div class="flex gap-2">
            <input v-model="trip.start_date" type="date"
              class="w-full px-4 py-2 rounded-tr-md rounded-br-md rounded-bl-md border border-soft-green bg-custom-white focus:ring-2 focus:ring-soft-green focus:outline-none" />
            <input v-model="trip.end_date" type="date"
              class="w-full px-4 py-2 rounded-tr-md rounded-br-md rounded-bl-md border border-soft-green bg-custom-white focus:ring-2 focus:ring-soft-green focus:outline-none" />
          </div>
        </div>

        <div>
          <label class="block text-lg font-semibold text-black mb-1">Nombre de voyageurs..</label>
          <input v-model.number="trip.guests" type="number"
            class="w-full px-4 py-2 rounded-tr-md rounded-br-md rounded-bl-md border border-soft-green bg-custom-white focus:ring-2 focus:ring-soft-green focus:outline-none" />
        </div>

        <div>
          <label class="block text-lg font-semibold text-black mb-1">Nombre de lits..</label>
          <input v-model.number="trip.beds" type="number"
            class="w-full px-4 py-2 rounded-tr-md rounded-br-md rounded-bl-md border border-soft-green bg-custom-white focus:ring-2 focus:ring-soft-green focus:outline-none" />
        </div>

        <div class="md:col-span-2 flex items-center">
          <label class="block text-lg font-semibold text-black mb-1">Combien d’étoiles..</label>
          <div class="flex items-center gap-1">
            <button v-for="n in 5" :key="n" @click="trip.stars = n" class="p-1 transition">
              <img :src="trip.stars >= n ? '/svg/Etoile_Jaune.svg' : '/svg/Etoile_Transparent.svg'" alt="star"
                class="w-5 h-5" />
            </button>
          </div>
        </div>

        <div class="md:col-span-2">
          <label class="block text-lg font-semibold text-black mb-2">Fourchette de prix <span
              class="text-xs">/nuit</span></label>
          <div class="flex items-center gap-4">
            <div class="flex flex-col">
              <label class="text-xs text-gray-500 mb-1">Prix min</label>
              <input v-model.number="trip.price_min" type="number" placeholder="ex: 50" min="0"
                class="px-4 py-2 border border-soft-green rounded-tr-md rounded-br-md rounded-bl-md bg-custom-white focus:ring-2 focus:ring-soft-green focus:outline-none w-32" />
            </div>
            <span class="text-gray-600 mt-6">→</span>
            <div class="flex flex-col">
              <label class="text-xs text-gray-500 mb-1">Prix max</label>
              <input v-model.number="trip.price_max" type="number" placeholder="ex: 300" min="0"
                class="px-4 py-2 border border-soft-green rounded-tr-md rounded-br-md rounded-bl-md bg-custom-white focus:ring-2 focus:ring-soft-green focus:outline-none w-32" />
            </div>
          </div>
        </div>

        <div class="md:col-span-2">
          <label class="block text-lg font-semibold text-black mb-1">Équipement..</label>
          <div class="flex flex-wrap gap-3">
            <label v-for="equip in equipment.equipements" :key="equip.key"
              class="flex items-center gap-2 px-4 py-2 border border-black bg-custom-white 
                     text-lg font-medium rounded-tr-lg rounded-br-lg rounded-bl-lg cursor-pointer transition hover:shadow"
              :class="trip.equipment.includes(equip.key) ? 'bg-soft-green text-white border-soft-green' : ''"
              @click.prevent="toggleEquip(equip.key)">
              <img :src="`/svg/${equip.icon}.svg`" class="w-5 h-5" />
              {{ equip.label }}
            </label>
          </div>
        </div>

        <div class="md:col-span-2">
          <label class="block text-lg font-semibold text-black mb-1">Petit +..</label>
          <div class="flex flex-wrap gap-3">
            <label v-for="plus in equipment.petits_plus" :key="plus.key"
              class="flex items-center gap-2 px-4 py-2 border border-black bg-custom-white 
                     text-lg font-medium rounded-tr-lg rounded-br-lg rounded-bl-lg cursor-pointer transition hover:shadow"
              :class="trip.equipment.includes(plus.key) ? 'bg-soft-green text-white border-soft-green' : ''"
              @click.prevent="toggleEquip(plus.key)">
              <img :src="`/svg/${plus.icon}.svg`" class="w-5 h-5" />
              {{ plus.label }}
            </label>
          </div>
        </div>

        <div class="md:col-span-2">
          <label class="block text-lg font-semibold text-black mb-1">+ D’accessibilité</label>
          <div class="flex flex-wrap gap-3">
            <label v-for="acc in equipment.accessibilite" :key="acc.key"
              class="flex items-center gap-2 px-4 py-2 border border-black bg-custom-white 
                     text-lg font-medium rounded-tr-lg rounded-br-lg rounded-bl-lg cursor-pointer transition hover:shadow"
              :class="trip.equipment.includes(acc.key) ? 'bg-soft-green text-white border-soft-green' : ''"
              @click.prevent="toggleEquip(acc.key)">
              <img :src="`/svg/${acc.icon}.svg`" class="w-5 h-5" />
              {{ acc.label }}
            </label>
          </div>
        </div>
      </div>

      <div class="flex justify-center mt-8">
        <button @click="submitTrip"
          class="bg-primary hover:bg-soft-green text-white font-semibold px-8 py-2 rounded transition">
          Sauvegarder
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue'

const emit = defineEmits(['close', 'create'])
const isOpen = ref(true)

const trip = ref({
  city: '',
  start_date: '',
  end_date: '',
  price_min: 0,
  price_max: 500,
  guests: 1,
  number_of_beds: 1,
  stars: 3,
  equipment: []
})

const equipment = {
  equipements: [
    { key: 'wifi', label: 'Wifi', icon: 'Wi-Fi_Connected' },
    { key: 'cuisine', label: 'Cuisine', icon: 'Ingredients' },
    { key: 'lave_linge', label: 'Lave linge', icon: 'Dishwasher' },
    { key: 'seche_linge', label: 'Sèche linge', icon: 'Tumble_Dry' },
    { key: 'climatisation', label: 'Climatisation', icon: 'Cooling' },
    { key: 'chauffage', label: 'Chauffage', icon: 'Heating' },
    { key: 'television', label: 'Télévision', icon: 'TV' },
    { key: 'fer_a_repasser', label: 'Fer à repasser', icon: 'Weber' }
  ],
  petits_plus: [
    { key: 'piscine', label: 'Piscine', icon: 'Swimmer' },
    { key: 'jacuzzi', label: 'Jacuzzi', icon: 'Jacuzzi' },
    { key: 'parking', label: 'Parking', icon: 'Parking' },
    { key: 'recharge_voiture', label: 'Recharge voiture', icon: 'Electric_Vehicle_Charging' },
    { key: 'lit_bebe', label: 'Lit bébé', icon: 'Crib' },
    { key: 'salle_de_sport', label: 'Salle de sport', icon: 'Dumbbell' },
    { key: 'bord_de_mer', label: 'Bord de mer', icon: 'Tsunami' },
    { key: 'barbecue', label: 'Barbecue', icon: 'Cocktail' },
    { key: 'petit_dejeuner', label: 'Petit déjeuner', icon: 'MacBook' },
    { key: 'diner', label: 'Dîner', icon: 'Chair' },
    { key: 'cheminee', label: 'Cheminée', icon: 'Tent_in_the_Forest' },
    { key: 'fumeur', label: 'Fumeur', icon: 'Cigar' }
  ],
  accessibilite: [
    { key: 'acces_plain_pied', label: 'Accès plain-pied', icon: 'Footsteps' },
    { key: 'parking_pmr', label: 'Parking PMR', icon: 'Parking' },
    { key: 'entree_large', label: 'Entrée large', icon: 'Front_Door_Sensor' },
    { key: 'barre_soutien', label: 'Barre de soutien', icon: 'Barre' },
    { key: 'siege_douche', label: 'Siège douche', icon: 'Wheelchair_support' }
  ]
}

function closeModal() {
  emit('close')
  isOpen.value = false
}

function submitTrip() {
  if (!trip.value.city) {
    alert("Merci de renseigner la destination")
    return
  }
  emit('create', trip.value)
  closeModal()
}

function toggleEquip(equipKey) {
  const index = trip.value.equipment.indexOf(equipKey)
  if (index > -1) {
    trip.value.equipment.splice(index, 1)
  } else {
    trip.value.equipment.push(equipKey)
  }
}
</script>

<style scoped>
.hide-scrollbar {
  scrollbar-width: none; 
  -ms-overflow-style: none;  
}

.hide-scrollbar::-webkit-scrollbar {
  display: none; 
}

</style>