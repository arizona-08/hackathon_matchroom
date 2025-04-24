<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white w-full max-w-2xl rounded-lg p-6 shadow-lg overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Créer un nouveau séjour</h2>
  
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-600 text-sm font-medium mb-1">Nom du séjour</label>
            <input v-model="trip.name" type="text" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700" />
          </div>
  
          <div>
            <label class="block text-gray-600 text-sm font-medium mb-1">Destination</label>
            <input v-model="trip.city" type="text" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700" />
          </div>
  
          <div>
            <label class="block text-gray-600 text-sm font-medium mb-1">Date de début</label>
            <input v-model="trip.start_date" type="date" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700" />
          </div>
  
          <div>
            <label class="block text-gray-600 text-sm font-medium mb-1">Date de fin</label>
            <input v-model="trip.end_date" type="date" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700" />
          </div>
  
          <div>
            <label class="block text-gray-600 text-sm font-medium mb-1">Prix minimum</label>
            <input v-model.number="trip.price_min" type="number" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700" />
          </div>
  
          <div>
            <label class="block text-gray-600 text-sm font-medium mb-1">Prix maximum</label>
            <input v-model.number="trip.price_max" type="number" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700" />
          </div>
  
          <div>
            <label class="block text-gray-600 text-sm font-medium mb-1">Nombre de personnes</label>
            <input v-model.number="trip.guests" type="number" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700" />
          </div>
  
          <div>
            <label class="block text-gray-600 text-sm font-medium mb-1">Nombre de lits</label>
            <input v-model.number="trip.beds" type="number" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700" />
          </div>
  
          <div class="md:col-span-2">
            <label class="block text-gray-600 text-sm font-medium mb-1">Étoiles minimum</label>
            <select v-model.number="trip.stars" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-700">
              <option value="">Indifférent</option>
              <option v-for="n in 5" :key="n" :value="n">{{ n }} étoile{{ n > 1 ? 's' : '' }}</option>
            </select>
          </div>
  
          <div class="md:col-span-2">
            <label class="block text-gray-600 text-sm font-medium mb-1">Équipements</label>
            <div class="grid grid-cols-2 gap-2">
              <label v-for="equip in equipmentList" :key="equip" class="flex items-center">
                <input type="checkbox" v-model="trip.equipment" :value="equip" class="mr-2" /> {{ equip }}
              </label>
            </div>
          </div>
        </div>
  
        <div class="flex justify-end gap-2 mt-6">
          <button @click="closeModal" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-800">
            Annuler
          </button>
          <button @click="submitTrip" class="px-4 py-2 rounded bg-green-700 text-white hover:bg-green-800">
            Créer
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineEmits } from 'vue'
  
  const emit = defineEmits(['close', 'create'])
  const isOpen = ref(true)
  
  const equipmentList = [
    'Wifi', 'Cuisine', 'Lave linge', 'Sèche linge', 'Climatisation', 'Chauffage', 'Télévision', 'Fer à repasser',
    'Piscine', 'Jacuzzi', 'Parking', 'Recharge voiture', 'Lit bébé', 'Salle de sport', 'Bord de mer', 'Barbecue',
    'Petit déjeuner', 'Dîner', 'Cheminée', 'Fumeur',
    'Accès plain-pied', 'Parking PMR', 'Entrée < 81cm', 'Barre de soutien', 'Siège douche'
  ]
  
  const trip = ref({
    name: '',
    city: '',
    start_date: '',
    end_date: '',
    price_min: '',
    price_max: '',
    guests: '',
    beds: '',
    stars: '',
    equipment: []
  })
  
  function closeModal() {
    emit('close')
    isOpen.value = false
  }
  
  function submitTrip() {
    if (!trip.value.name || !trip.value.city) {
      alert("Merci de remplir les champs requis 😅")
      return
    }
  
    emit('create', trip.value)
    closeModal()
  }
  </script>
  