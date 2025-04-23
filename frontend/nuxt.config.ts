import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
<<<<<<< HEAD
  css: ['~/assets/css/main.css', 'mapbox-gl/dist/mapbox-gl.css'],
=======
  css: ['~/assets/css/main.css'],

>>>>>>> 7d63a1d (ajout du ssl config)
  vite: {
    plugins: [
      tailwindcss(),
    ],
    server: {
      hmr: {
        host: 'matchroom.online',
      },
      host: '0.0.0.0',
      allowedHosts: ['matchroom.online'],
    },
  },

  modules: [
    '@nuxt/eslint',
    '@nuxt/fonts',
    '@nuxt/icon',
    '@nuxt/image'
  ]
})
