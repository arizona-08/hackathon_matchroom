<template>
  <div class="min-h-screen flex items-center justify-center bg-custom-white px-4">
    <div class="w-full max-w-5xl bg-custom-white grid grid-cols-1 md:grid-cols-5 gap-4 items-center">

      <!-- Partie gauche : Formulaire -->
      <div class="p-10 col-span-2 flex justify-center">
        <LoginForm />
      </div>

      <!-- Séparateur -->
      <div class="hidden md:flex flex-col items-center justify-center text-gray-500 col-span-1">
        <div class="h-24 w-px bg-soft-green mb-2"></div>
        <span class="text-lg font-medium text-primary">ou</span>
        <div class="h-24 w-px bg-soft-green mt-2"></div>
      </div>

      <!-- Partie droite : Connexions sociales -->
      <div class="p-10 col-span-2 flex flex-col space-y-10">
        <SocialButton
          icon="/svg/Google_logo.svg"
          text="Continuer avec Google"
        />
        <SocialButton
          icon="/svg/Apple_logo.svg"
          text="Continuer avec Apple"
        />
        <SocialButton
          icon="/svg/Facebook_logo.svg"
          text="Continuer avec Facebook"
        />
      </div>

    </div>
  </div>
</template>

<script setup>
import LoginForm from '@/components/auth/LoginForm.vue'
import SocialButton from '@/components/auth/SocialButton.vue'
</script>
