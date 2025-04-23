import mapboxgl from 'mapbox-gl'

export default defineNuxtPlugin(() => {
  mapboxgl.accessToken = 'pk.eyJ1IjoibWlzb2thIiwiYSI6ImNseGhnczJweDE3bzMycnF0NHRqM3F0ZmoifQ.HHqpWObbvpH65lb6Ma14mQ';
  return {
    provide: {
      mapbox: mapboxgl
    }
  }
})
