<template>
  <section class="px-4 relative md:px-10">
    <div class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 w-full px-4 flex flex-col items-center justify-center gap-4">
      <h1 class="px-4 text-3xl text-white font-semibold text-center mb-4 md:text-4xl text-shadow-lg">Négociez vos nuits au meilleur prix.</h1>
      <form method="post" class="w-full flex flex-col items-center justify-center gap-4 mb-9">
        <input 
          type="search" 
          name="" 
          id="" 
          placeholder="Un quartier, une rue, une ville ?"
          class="bg-white border-gray-300 rounded-md p-2 w-10/12 px-4 py-2 placeholder:font-medium md:w-6/12"
        />
      </form>
    </div>

    <div class="w-full flex flex-col items-center justify-center gap-2 text-white absolute bottom-4 left-1/2 -translate-x-1/2">
        <p class="text-3xl font-semibold">< 3H</p>
        <p class="font-semibold">Temps de réponses des hôteliers</p>
        <div  class="w-20 h-2 rounded border overflow-hidden relative">
          <span id="timer"class="h-full bg-white w-0 absolute top-0 left-0"></span>
        </div>
      </div>
    
      <div class="img-container h-[410px] w-full lg:h-[446px]">
        <img
          src="/img/pngs_jpgs/beach.png"
          alt="" 
          class="object-cover w-full h-full"  
        >
      </div>

  </section>
</template>

<script setup>
</script>

<style scoped>
  #timer {
    animation: timer 3s linear infinite;
  }

  @keyframes timer {
    0% {
      width: 0;
    }
    100% {
      width: 100%;
    }
  }
</style>