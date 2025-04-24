<template>
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-email">
          <a href="mailto:contact@matchroom.io">contact@matchroom.io</a>
        </div>
        
        <div class="footer-copyright">
          © {{ currentYear }} - Matchroom SAS
        </div>
        
        <div class="footer-links">
          <a href="/conditions-generales" class="footer-link">Conditions Générales d'Utilisation</a>
          <a href="/confidentialite" class="footer-link">Politique de confidentialité</a>
        </div>
      </div>
    </footer>
  </template>
  
  <script setup>
  // Obtention de l'année courante pour le copyright
  const currentYear = new Date().getFullYear();
  </script>
  
  <style scoped>
  .footer {
    background-color: #0a4333; /* Couleur vert foncé comme sur l'image */
    color: white;
    padding: 2rem 0;
    width: 100%;
  }
  
  .footer-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
  }
  
  .footer-email a {
    color: white;
    text-decoration: none;
    font-size: 1.1rem;
  }
  
  .footer-copyright {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
  }
  
  .footer-links {
    display: flex;
    gap: 1.5rem;
  }
  
  .footer-link {
    color: white;
    text-decoration: none;
    font-size: 0.9rem;
    transition: opacity 0.2s;
  }
  
  .footer-link:hover {
    opacity: 0.8;
  }
  
  /* Responsive design */
  @media (max-width: 768px) {
    .footer-links {
      flex-direction: column;
      align-items: center;
      gap: 0.7rem;
    }
  }
  </style>