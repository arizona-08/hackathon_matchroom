<template>
    <section class="carousel-section">
      <h2 class="carousel-title">Bon plans</h2>
      <div class="carousel-wrapper" ref="carousel">
        <div v-for="(card, index) in cards" :key="index" class="carousel-card">
          <div class="image-wrapper">
            <img :src="card.image" :alt="card.title" class="card-image" />
            <div class="overlay">
              <div class="content-container">
                <div class="hotel-info">
                  <h3 class="card-title">{{ card.title }}</h3>
                  <div class="stars">
                    <span v-for="n in card.stars" :key="n" class="star">★</span>
                  </div>
                  <div class="location">{{ card.location }}</div>
                  <div class="tags">{{ card.tags.join(' - ') }}</div>
                </div>
                <div class="price-info">
                  <div class="price">{{ card.price }} /nuit</div>
                  <div class="nombre-personne">{{ card.nbPersonnes }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  
  const carousel = ref(null)
  
  const cards = [
    {
      image: "/img/bg.jpg",
      title: "Hotel Cayenne",
      stars: 3,
      location: "20 rue du canard - Nice",
      tags: ["Piscine", "Parking", "Bar", "Climatisations", "Chauffage"],
      price: "122 €",
      nbPersonnes: "2 personnes"
    },
    {
      image: "/img/bg.jpg",
      title: "Villa Méditerranée",
      stars: 4,
      location: "8 avenue de la Mer - Cannes",
      tags: ["Vue mer", "Terrasse", "Parking", "Clim"],
      price: "189 €",
      nbPersonnes: "4 personnes"
    },
    {
      image: "/img/bg.jpg",
      title: "Résidence Le Palais",
      stars: 5,
      location: "55 boulevard des Anglais - Nice",
      tags: ["Piscine", "Spa", "Restaurant", "Vue panoramique"],
      price: "250 €",
      nbPersonnes: "2 personnes"
    },
  ];
  
  onMounted(() => {
    // Optionnel : ajout d'une fonctionnalité de défilement automatique
    const scrollRight = () => {
      if (carousel.value) {
        carousel.value.scrollBy({
          left: 300,
          behavior: 'smooth'
        });
      }
    };
  
    const scrollInterval = setInterval(() => {
      if (carousel.value && 
          carousel.value.scrollLeft + carousel.value.clientWidth >= carousel.value.scrollWidth) {
        carousel.value.scrollTo({ left: 0, behavior: 'smooth' });
      } else {
        scrollRight();
      }
    }, 5000);
  
    return () => clearInterval(scrollInterval);
  })
  </script>
  
  <style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;700&display=swap');
  
  .carousel-section {
    font-family: 'Red Hat Display', sans-serif;
    padding: 1rem 0;
  }
  
  .carousel-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
  }
  
  .carousel-wrapper {
    display: flex;
    overflow-x: auto;
    gap: 1.5rem;
    scroll-snap-type: x mandatory;
    padding: 0.5rem 0;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none; /* Firefox */
  }
  
  .carousel-wrapper::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
  }
  
  .carousel-card {
    min-width: 28rem;
    height: 16rem;
    flex-shrink: 0;
    scroll-snap-align: start;
    border-radius: 1rem;
    overflow: hidden;
    position: relative;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }
  
  .image-wrapper {
    position: relative;
    height: 100%;
  }
  
  .card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 30%, transparent 70%);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 1.5rem;
  }
  
  .content-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    width: 100%;
  }
  
  .hotel-info {
    flex: 1;
  }
  
  .card-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
  }
  
  .stars {
    color: gold;
    font-size: 1rem;
    margin-bottom: 0.5rem;
  }
  
  .star {
    margin-right: 0.1rem;
  }
  
  .location {
    font-size: 1rem;
    margin-bottom: 0.75rem;
  }
  
  .tags {
    font-size: 0.85rem;
    opacity: 0.8;
  }
  
  .price-info {
    text-align: right;
  }
  
  .price {
    font-size: 1.75rem;
    font-weight: bold;
  }
  
  .nombre-personne {
    font-size: 1rem;
  }
  </style>