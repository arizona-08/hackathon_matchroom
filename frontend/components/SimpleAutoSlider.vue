<template>
  <div class="slider-container">
    <h2 class="section-title">Bon plans.</h2>
    
    <div class="slider-wrapper">
      <div class="slider-track" ref="track">
        <div v-for="(hotel, index) in hotels" :key="index" class="slider-item">
          <div class="hotel-card">
            <img :src="hotel.image" :alt="hotel.name" class="hotel-image">
            
            <div class="hotel-info">
              <div class="hotel-header">
                <h3 class="hotel-name">{{ hotel.name }} <span class="hotel-stars">{{ hotel.stars }}</span></h3>
                <p class="hotel-address">{{ hotel.address }}</p>
              </div>
              
              <div class="hotel-price">
                <p class="price">{{ hotel.price }} <span class="price-period">€ /nuit</span></p>
                <p class="people">{{ hotel.people }} personnes</p>
              </div>
            </div>
            
            <div class="hotel-features">
              <span v-for="(feature, fidx) in hotel.features" :key="fidx" class="feature">{{ feature }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// Données d'hôtels
const hotels = ref([
  {
    name: 'Hotel Cosy',
    stars: '⭐⭐⭐',
    address: '37 rue de la canaille - Nice',
    price: '220',
    people: '4',
    image: '/img/hotel-cosy.jpg', // Remplacez par votre chemin d'image
    features: ['Piscine', 'Parking', 'Petit déjeuner', 'Bord de mer', 'Bar', 'Climatisations', 'Chauffage']
  },
  {
    name: 'Hotel Cosy',
    stars: '⭐⭐⭐',
    address: '37 rue de la canaille - Nice',
    price: '220',
    people: '4',
    image: '/img/hotel-cosy.jpg', // Remplacez par votre chemin d'image
    features: ['Piscine', 'Parking', 'Petit déjeuner', 'Bord de mer', 'Bar', 'Climatisations', 'Chauffage']
  },
  {
    name: 'Grand Hotel',
    stars: '⭐⭐⭐⭐',
    address: '28 boulevard des Anglais - Nice',
    price: '350',
    people: '2',
    image: '/img/hotel-cosy.jpg', // Remplacez par votre chemin d'image
    features: ['Spa', 'Piscine', 'Restaurant', 'Vue mer', 'Wifi', 'Climatisations', 'Salle de sport']
  },
  {
    name: 'Villa Bleu',
    stars: '⭐⭐⭐⭐⭐',
    address: '12 avenue des fleurs - Cannes',
    price: '520',
    people: '6',
    image: '/img/hotel-cosy.jpg', // Remplacez par votre chemin d'image
    features: ['Piscine privée', 'Jardin', 'Terrasse', 'Vue panoramique', 'Service ménage', 'Climatisations']
  }
]);

const track = ref(null);
let animationId = null;
let position = 0;

// Fonction pour animer le défilement
const animateSlider = () => {
  // Décrémente la position (déplacement de droite à gauche)
  position -= 1;
  
  // Si la première carte est complètement sortie, on la remet à la fin
  if (position <= -300) { // Supposant que 300px est la largeur d'une carte
    // Réinitialisation de la position
    position = 0;
    
    // Déplacement du premier élément à la fin
    const firstHotel = hotels.value.shift();
    hotels.value.push(firstHotel);
  }
  
  // Application du déplacement
  if (track.value) {
    track.value.style.transform = `translateX(${position}px)`;
  }
  
  // Boucle d'animation
  animationId = requestAnimationFrame(animateSlider);
};

onMounted(() => {
  // Démarrer l'animation après le montage du composant
  animationId = requestAnimationFrame(animateSlider);
  
  // Pause l'animation quand l'utilisateur survole le slider
  track.value.addEventListener('mouseenter', () => {
    cancelAnimationFrame(animationId);
  });
  
  // Reprend l'animation quand l'utilisateur quitte le slider
  track.value.addEventListener('mouseleave', () => {
    animationId = requestAnimationFrame(animateSlider);
  });
});

onUnmounted(() => {
  // Nettoyage de l'animation à la destruction du composant
  if (animationId) {
    cancelAnimationFrame(animationId);
  }
});
</script>

<style scoped>
.slider-container {
  padding: 3rem 1rem;
  background-color: #f2f3f5;
  overflow: hidden;
}

.section-title {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 2rem;
  padding-left: 1rem;
  max-width: 1400px;
  margin-left: auto;
  margin-right: auto;
}

.slider-wrapper {
  max-width: 100%;
  overflow: hidden;
  position: relative;
}

.slider-track {
  display: flex;
  transition: transform 0.1s linear;
  gap: 20px;
  padding-right: 20px; /* Espace supplémentaire pour que le dernier élément soit visible */
}

.slider-item {
  flex: 0 0 300px; /* Largeur fixe des cartes */
  max-width: 300px;
  padding: 0;
  box-sizing: border-box;
}

.hotel-card {
  border-radius: 15px;
  overflow: hidden;
  background-color: white;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  height: 100%;
  display: flex;
  flex-direction: column;
}

.hotel-image {
  width: 100%;
  height: 180px;
  object-fit: cover;
  object-position: center;
}

.hotel-info {
  padding: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}

.hotel-header {
  flex: 1;
}

.hotel-name {
  font-size: 1.1rem;
  font-weight: bold;
  margin: 0 0 0.3rem 0;
}

.hotel-stars {
  font-size: 0.8rem;
  letter-spacing: 1px;
}

.hotel-address {
  font-size: 0.8rem;
  color: #666;
  margin: 0;
}

.hotel-price {
  text-align: right;
}

.price {
  font-size: 1.1rem;
  font-weight: bold;
  margin: 0;
}

.price-period {
  font-size: 0.8rem;
  font-weight: normal;
}

.people {
  font-size: 0.75rem;
  color: #666;
  margin: 0.2rem 0 0;
}

.hotel-features {
  padding: 0.5rem 1rem 1rem;
  display: flex;
  flex-wrap: wrap;
  gap: 0.4rem;
}

.feature {
  background-color: #f0f0f0;
  padding: 0.2rem 0.6rem;
  border-radius: 20px;
  font-size: 0.7rem;
  white-space: nowrap;
}

/* Responsive - ajustement pour les petits écrans */
@media (max-width: 768px) {
  .slider-item {
    flex: 0 0 260px;
    max-width: 260px;
  }
  
  .hotel-info {
    flex-direction: column;
  }
  
  .hotel-price {
    text-align: left;
    margin-top: 0.8rem;
  }
}
</style>