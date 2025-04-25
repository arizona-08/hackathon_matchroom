<template>
  <section class="carousel-section">
    <h2 class="carousel-title">Les plus populaires.</h2>

    <div class="carousel-container" @mousedown="startDrag" @mousemove="onDrag" @mouseup="endDrag" @mouseleave="endDrag"
      @touchstart="startDragTouch" @touchmove="onDragTouch" @touchend="endDragTouch">

      <button class="nav-button prev" @click="prevSlide">
        <Icon name="mdi:chevron-left" />
      </button>

      <div class="carousel-track" :style="{ transform: `translateX(${translateX}px)` }">
        <div v-for="(card, index) in cards" :key="index" v-if="getRelativePosition(index) !== 99" class="carousel-item"
          :class="getPositionClass(index)" :style="getCardStyle(index)">

          <div class="card-image">
            <img :src="card.image" :alt="card.title" />

            <div v-if="getRelativePosition(index) === 0" class="image-overlay">
              <div class="content-container">
                <div class="hotel-info">
                  <h3 class="hotel-title">{{ card.title }}</h3>
                  <div class="stars">
                    <span v-for="n in card.stars" :key="n" class="star">★</span>
                  </div>
                  <div class="location">{{ card.location }}</div>
                  <div class="amenities">{{ card.tags.join(' - ') }}</div>
                </div>
                <div class="price-info">
                  <div class="price">{{ card.price }} /nuit</div>
                  <div class="guests">{{ card.nbPersonnes }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <button class="nav-button next" @click="nextSlide">
        <Icon name="mdi:chevron-right" />
      </button>
    </div>

    <div class="carousel-dots">
      <button v-for="(card, index) in cards" :key="index" :class="['carousel-dot', { active: currentIndex === index }]"
        @click="goToSlide(index)">
      </button>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

// Données du carrousel
const cards = ref([
  {
    title: 'Hotel Cayenne',
    stars: 3,
    location: '20 rue du canard - Nice',
    price: '122 €',
    nbPersonnes: '2 personnes',
    image: '/img/bg.jpg',
    tags: ['Piscine', 'Parking', 'Bar', 'Climatisations', 'Chauffage']
  },
  {
    title: 'Résidence Le Méditerranée',
    stars: 4,
    location: '15 avenue de la Mer - Cannes',
    price: '175 €',
    nbPersonnes: '4 personnes',
    image: '/img/bg1.jpg',
    tags: ['Vue Mer', 'Parking', 'WiFi', 'Climatisations']
  },
  {
    title: 'La Villa Azur',
    stars: 5,
    location: '8 chemin des Oliviers - Antibes',
    price: '230 €',
    nbPersonnes: '2 personnes',
    image: '/img/bg.jpg',
    tags: ['Piscine', 'Spa', 'Restaurant', 'Vue Mer']
  },
  {
    title: 'Auberge du Soleil',
    stars: 3,
    location: '42 route des Vignes - Grasse',
    price: '95 €',
    nbPersonnes: '2 personnes',
    image: '/img/bg1.jpg',
    tags: ['Jardin', 'Terrasse', 'Petit-déjeuner']
  },
  {
    title: 'Grand Hôtel du Palais',
    stars: 4,
    location: '3 place Masséna - Nice',
    price: '210 €',
    nbPersonnes: '3 personnes',
    image: '/img/bg.jpg',
    tags: ['Restaurant étoilé', 'Spa', 'Concierge']
  }
]);

// État du carrousel
const currentIndex = ref(0);
const translateX = ref(0);
const isDragging = ref(false);
const dragStartX = ref(0);
const dragStartTranslateX = ref(0);

// Pour la gestion tactile
const touchStartX = ref(0);

// Fonctions de navigation
const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % cards.value.length;
};

const prevSlide = () => {
  currentIndex.value = (currentIndex.value - 1 + cards.value.length) % cards.value.length;
};

const goToSlide = (index) => {
  currentIndex.value = index;
};

// Gestion du positionnement relatif des cartes
const getRelativePosition = (index) => {
  const positions = cards.value.length;
  let relPos = (index - currentIndex.value + positions) % positions;
  relPos = relPos <= positions / 2 ? relPos : relPos - positions;

  // Limiter à ±3 (affiche max 3 de chaque côté)
  if (Math.abs(relPos) > 3) return 99; // carte trop loin
  return relPos;
};

// Détermine la classe CSS en fonction de la position relative
const getPositionClass = (index) => {
  const relPos = getRelativePosition(index);

  if (relPos === 0) return 'position-center';
  if (relPos > 0) {
    return `position-right level-${relPos}`;
  } else if (relPos < 0) {
    return `position-left level-${Math.abs(relPos)}`;
  }

  return '';
};

// Calcule les styles CSS pour chaque carte
const getCardStyle = (index) => {
  const relPos = getRelativePosition(index);
  let opacity = 1;
  let scale = 1;

  // Ajustez l'opacité et l'échelle en fonction de la position
  if (relPos !== 0) {
    opacity = Math.max(0.4, 1 - Math.abs(relPos) * 0.2);
    scale = Math.max(0.85, 1 - Math.abs(relPos) * 0.05);
  }

  return {
    zIndex: 100 - Math.abs(relPos),
    opacity: opacity,
    transform: `scale(${scale})`
  };
};

// Gestion du glissement (desktop)
const startDrag = (e) => {
  isDragging.value = true;
  dragStartX.value = e.clientX;
  dragStartTranslateX.value = translateX.value;
};

const onDrag = (e) => {
  if (!isDragging.value) return;

  const deltaX = e.clientX - dragStartX.value;
  translateX.value = dragStartTranslateX.value + deltaX;

  // Prévenir le comportement par défaut pour éviter le sélection de texte
  e.preventDefault();
};

const endDrag = (e) => {
  if (!isDragging.value) return;

  const deltaX = e.clientX - dragStartX.value;

  if (Math.abs(deltaX) > 100) {
    // Si le glissement est suffisamment important, changez de diapositive
    if (deltaX > 0) {
      prevSlide();
    } else {
      nextSlide();
    }
  }

  // Réinitialisation après le glissement
  translateX.value = 0;
  isDragging.value = false;
};

// Gestion du glissement (mobile)
const startDragTouch = (e) => {
  isDragging.value = true;
  touchStartX.value = e.touches[0].clientX;
  dragStartTranslateX.value = translateX.value;
};

const onDragTouch = (e) => {
  if (!isDragging.value) return;

  const deltaX = e.touches[0].clientX - touchStartX.value;
  translateX.value = dragStartTranslateX.value + deltaX;
};

const endDragTouch = (e) => {
  if (!isDragging.value) return;

  // Calculez la distance parcourue
  const touchEndX = e.changedTouches[0].clientX;
  const deltaX = touchEndX - touchStartX.value;

  if (Math.abs(deltaX) > 80) {
    // Si le glissement est suffisamment important, changez de diapositive
    if (deltaX > 0) {
      prevSlide();
    } else {
      nextSlide();
    }
  }

  // Réinitialisation après le glissement
  translateX.value = 0;
  isDragging.value = false;
};

// Démarrage de l'auto-rotation (facultatif)
let autoRotateTimer = null;

const startAutoRotate = () => {
  autoRotateTimer = setInterval(() => {
    nextSlide();
  }, 5000); // Rotation toutes les 5 secondes
};

const stopAutoRotate = () => {
  if (autoRotateTimer) {
    clearInterval(autoRotateTimer);
  }
};

onMounted(() => {
  // Démarrez la rotation automatique
  startAutoRotate();

  // Arrêtez la rotation lors de l'interaction
  const container = document.querySelector('.carousel-container');
  container.addEventListener('mouseenter', stopAutoRotate);
  container.addEventListener('mouseleave', startAutoRotate);
  container.addEventListener('touchstart', stopAutoRotate);
  container.addEventListener('touchend', () => {
    // Petit délai avant de redémarrer pour éviter les conflits
    setTimeout(startAutoRotate, 1000);
  });
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;700&display=swap');

.carousel-section {
  font-family: 'Red Hat Display', sans-serif;
  max-width: 1400px;
  margin: 0 auto;
  padding: 2rem 1rem;
  position: relative;
  overflow: visible;
}

.carousel-title {
  font-size: 3.1rem;
  font-weight: normal;
  margin-bottom: 2rem;
  color: #0a4333;
}

.carousel-container {
  position: relative;
  height: 500px;
  cursor: grab;
  margin: 0 auto;
  /* Changement important: passer de "overflow: hidden" à "overflow: visible" */
  overflow: visible;
  display: flex;
  align-items: center;
  padding: 0 5%;
  /* Ajouter un peu d'espace sur les côtés */
}

.carousel-container:active {
  cursor: grabbing;
}

.carousel-track {
  position: relative;
  width: 100%;
  height: 100%;
  transform-style: preserve-3d;
  transition: transform 0.3s ease;
  display: flex;
  align-items: center;
}

/* Boutons de navigation */
.nav-button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.8);
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 101;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: all 0.2s ease;
}

.nav-button:hover {
  background-color: white;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}

.nav-button.prev {
  left: 10px;
}

.nav-button.next {
  right: 10px;
}

/* Styles pour les éléments du carousel */
.carousel-item {
  position: absolute;
  top: 0;
  left: 50%;
  transform-origin: center center;
  transition: all 0.8s ease;
  width: 65%;
  height: 90%;
  margin: 0 -32.5%;
  /* Pour centrer les cartes */
}

.carousel-item.position-center {
  transform: translateX(0) translateZ(100px) rotateY(0deg);
  z-index: 10;
  opacity: 1;
}

.carousel-item.position-left {
  transform: translateX(-70%) translateZ(-20px) rotateY(25deg);
  z-index: 5;
  opacity: 0.8;
}

.carousel-item.position-right {
  transform: translateX(70%) translateZ(-20px) rotateY(-25deg);
  z-index: 5;
  opacity: 0.8;
}

.carousel-item.position-back {
  opacity: 0.6;
  z-index: 1;
}

.carousel-item.position-far-left {
  transform: translateX(-110%) translateZ(-50px) rotateY(35deg);
  z-index: 3;
  opacity: 0.5;
}

.carousel-item.position-far-right {
  transform: translateX(110%) translateZ(-50px) rotateY(-35deg);
  z-index: 3;
  opacity: 0.5;
}

.carousel-item.position-back-left {
  transform: translateX(-120%) translateZ(-50px) rotateY(30deg);
}

.carousel-item.position-back-right {
  transform: translateX(120%) translateZ(-50px) rotateY(-30deg);
}

.card-image {
  width: 100%;
  height: 100%;
  position: relative;
  border-radius: 1rem;
  overflow: hidden;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Styles pour l'overlay d'informations */
.image-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
  color: #fff;
  padding: 1.5rem;
  border-bottom-left-radius: 1rem;
  border-bottom-right-radius: 1rem;
  transition: opacity 0.3s ease;
}

.content-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}

.hotel-info {
  flex: 1;
}

.hotel-title {
  font-size: 1.8rem;
  margin: 0 0 0.5rem;
  font-weight: bold;
}

.stars {
  color: gold;
  margin-bottom: 0.5rem;
}

.location {
  font-size: 1rem;
  margin-bottom: 0.5rem;
  opacity: 0.8;
}

.amenities {
  font-size: 0.9rem;
  opacity: 0.7;
}

.price-info {
  text-align: right;
}

.price {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 0.3rem;
}

.guests {
  font-size: 0.9rem;
  opacity: 0.8;
}

/* Styles pour les indicateurs */
.carousel-dots {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
  gap: 10px;
}

.carousel-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: rgba(10, 67, 51, 0.3);
  border: none;
  cursor: pointer;
  padding: 0;
  transition: all 0.3s ease;
}

.carousel-dot.active {
  background-color: #0a4333;
  transform: scale(1.2);
}

/* Responsive adjustments */
@media screen and (max-width: 768px) {
  .carousel-item {
    width: 85%;
    margin: 0 -42.5%;
  }

  .carousel-item.position-left {
    transform: translateX(-45%) translateZ(0) rotateY(10deg);
  }

  .carousel-item.position-right {
    transform: translateX(45%) translateZ(0) rotateY(-10deg);
  }

  .hotel-title {
    font-size: 1.4rem;
  }

  .carousel-title {
    font-size: 2.5rem;
  }
}

@media screen and (max-width: 480px) {
  .carousel-item {
    width: 95%;
    margin: 0 -47.5%;
  }

  .carousel-item.position-left,
  .carousel-item.position-right {
    opacity: 0.5;
  }
}

/* Position dynamiques - droite */
.carousel-item.position-right.level-1 {
  transform: translateX(70%) translateZ(-20px) rotateY(-20deg);
  z-index: 9;
  opacity: 0.9;
}

.carousel-item.position-right.level-2 {
  transform: translateX(120%) translateZ(-60px) rotateY(-30deg);
  z-index: 8;
  opacity: 0.7;
}

.carousel-item.position-right.level-3 {
  transform: translateX(170%) translateZ(-90px) rotateY(-40deg);
  z-index: 7;
  opacity: 0.5;
}

/* Position dynamiques - gauche */
.carousel-item.position-left.level-1 {
  transform: translateX(-70%) translateZ(-20px) rotateY(20deg);
  z-index: 9;
  opacity: 0.9;
}

.carousel-item.position-left.level-2 {
  transform: translateX(-120%) translateZ(-60px) rotateY(30deg);
  z-index: 8;
  opacity: 0.7;
}

.carousel-item.position-left.level-3 {
  transform: translateX(-170%) translateZ(-90px) rotateY(40deg);
  z-index: 7;
  opacity: 0.5;
}
</style>