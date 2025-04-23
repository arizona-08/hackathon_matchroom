<template>
    <div class="map-container relative w-full h-[75vh]">
      <div class="absolute z-10 top-4 left-4 right-4 flex gap-2 bg-white p-2 rounded shadow">
        <input
          v-model="searchQuery"
          placeholder="Rechercher une ville, ex: Paris"
          class="flex-1 border border-gray-300 p-2 rounded"
          @keyup.enter="searchCity"
        />
        <button class="bg-blue-600 text-white px-4 rounded" @click="searchCity">🔍</button>
      </div>
  
      <div ref="mapContainer" class="w-full h-full" />
  
      <SearchBar @search="handleSearch" />
      <FilterPanel @filter="applyFilters" />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { getMapData } from '~/lib/map'
  
  const mapContainer = ref(null)
  const searchQuery = ref('')
  let map
  
  const { $mapbox } = useNuxtApp()
  
  onMounted(() => {
    map = new $mapbox.Map({
      container: mapContainer.value,
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [2.3522, 48.8566], // Paris
      zoom: 12,
    })
  
    map.on('load', loadRoomsOnly)
  })
  
  async function searchCity() {
    if (!searchQuery.value) return
  
    const query = encodeURIComponent(searchQuery.value)
    const res = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${query}.json?access_token=${$mapbox.accessToken}`)
    const data = await res.json()
    const coords = data.features[0]?.center
  
    if (coords) {
      map.flyTo({ center: coords, zoom: 12 })
    }
  }
  
  async function loadRoomsOnly() {
    try {
      const { data } = await getMapData()
  
      if (!Array.isArray(data)) {
        console.error('Résultat API inattendu :', data)
        return
      }
  
      data
        .filter(item => item.type === 'room')
        .forEach(room => {
          if (!room.latitude || !room.longitude) return
  
          const el = document.createElement('div')
          el.className = 'price-marker'
          el.innerHTML = `<span>${parseFloat(room.price_per_night).toFixed(2)}€</span>`
  
          new $mapbox.Marker(el)
            .setLngLat([parseFloat(room.longitude), parseFloat(room.latitude)])
            .setPopup(
              new $mapbox.Popup({ offset: 25, className: 'custom-popup' }).setHTML(`
                <div class="popup-room-card">
                  <h3>${room.name}</h3>
                  <p>${room.description}</p>
                </div>
              `)
            )
            .addTo(map)
        })
    } catch (error) {
      console.error('[MAP LOAD ERROR]', error)
    }
  }
  
  function handleSearch(query) {
    // Placeholder pour la future logique de recherche
  }
  
  function applyFilters(filters) {
    // Placeholder pour la future logique de filtre
  }
  </script>
  
  <style>
  .map-container .price-marker {
    background-color: #ffffff;
    border: 2px solid #083A31;
    border-radius: 6px;
    padding: 4px 8px;
    font-weight: bold;
    color: #083A31;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
    font-size: 13px;
    white-space: nowrap;
    cursor: pointer;
    transform: translateY(-50%);
  }
  
  .map-container .price-marker span {
    display: inline-block;
  }
  
  /* Popup stylisée */
  .custom-popup .mapboxgl-popup-content {
    background: #3F6868;
    color: #fff;
    border-radius: 10px;
    padding: 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    width: 250px;
    font-family: 'Arial', sans-serif;
    overflow: hidden;
  }
  
  .custom-popup .mapboxgl-popup-close-button {
    color: #fff;
    top: 4px;
    right: 8px;
  }
  
  .popup-room-card {
    padding: 16px;
  }
  
  .popup-room-card h3 {
    font-size: 16px;
    margin: 0 0 8px;
    color: #fff;
  }
  
  .popup-room-card p {
    margin: 0;
    font-size: 14px;
    line-height: 1.4;
    color: #ccc;
  }
  </style>
  