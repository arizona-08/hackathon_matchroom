<template>
    <section class="hero-container">
      <!-- L'image de fond sera gérée en CSS avec l'URL que vous fournirez -->
      <div class="hero-overlay">
        <div class="content-container">
          <!-- Titre principal -->
          <h1 class="hero-title">Négociez vos nuits, au meilleur prix.</h1>
          
          <!-- Barre de recherche -->
          <div class="search-container">
            <input 
              type="text" 
              class="search-input" 
              placeholder="Un quartier, une rue, une vue ?"
            >
          </div>
          
          <!-- Statistiques -->
          <div class="stats-container">
            <div class="stat-item">
              <div class="stat-value">100%</div>
              <div class="stat-label">Taux de réponses des hôteliers</div>
            </div>
            
            <div class="stat-item">
              <div class="stat-value">< 3H</div>
              <div class="stat-label">Temps de réponses des hôteliers</div>
            </div>
            
            <div class="stat-item">
              <div class="stat-value">22%</div>
              <div class="stat-label">de réduction moyenne</div>
            </div>
          </div>
        </div>
      </div>
      
   
    </section>
  </template>
  
  <script setup>
  // Vous pouvez ajouter ici la logique pour la barre de recherche ou d'autres fonctionnalités
  </script>
  
  <style scoped>
  .hero-container {
    position: relative;
    width: 100%;
    height: 500px;
    background-image: url('../../public/img/beach.png'); /* Remplacez par le chemin de votre image */
    background-size: cover;
    background-position: center;
    color: white;
    overflow: hidden;
  }
  
  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.1); /* Léger assombrissement pour améliorer la lisibilité */
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .content-container {
    width: 80%;
    max-width: 1200px;
    text-align: center;
  }
  
  .hero-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 2rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
  }
  
  .search-container {
    margin-bottom: 3rem;
  }
  
  .search-input {
    width: 100%;
    max-width: 600px;
    padding: 1rem 1.5rem;
    border-radius: 50px;
    border: none;
    font-size: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  .stats-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 2rem;
  }
  
  .stat-item {
    flex: 1;
    min-width: 150px;
  }
  
  .stat-value {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
  
  .stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
  }
  
  .side-menu {
    position: absolute;
    top: 0;
    right: 0;
    background-color: rgba(0, 58, 41, 0.9); /* Couleur verte foncée semi-transparente */
    height: 100%;
    display: flex;
    flex-direction: column;
    padding: 1rem;
    min-width: 150px;
  }
  
  .menu-item {
    color: white;
    text-decoration: none;
    padding: 0.7rem 1rem;
    transition: background-color 0.2s;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }
  
  .menu-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .hero-title {
      font-size: 2rem;
    }
    
    .stats-container {
      flex-direction: column;
      align-items: center;
    }
    
    .stat-item {
      text-align: center;
    }
    
    .side-menu {
      min-width: 120px;
    }
  }
  </style>