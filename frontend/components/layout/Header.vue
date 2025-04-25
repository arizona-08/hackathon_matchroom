<template>
    <header class="header-container">
      <div class="logo-container">
        <NuxtLink to="/">
          <div class="logo">
            <img src="/svg/logo.svg" alt="MatchRoom Logo" class="logo-icon" />
            <span class="logo-text">MatchRoom</span>
          </div>
        </NuxtLink>
      </div>
      
      <nav class="navigation">
        <ul class="nav-list">
          <li class="nav-item" :class="{ active: currentRoute === 'filtres' }">
            <NuxtLink to="/filtres">Filtres</NuxtLink>
          </li>
          <li class="nav-item" :class="{ active: currentRoute === 'match' }">
            <NuxtLink to="/match">Match</NuxtLink>
          </li>
          <li class="nav-item" :class="{ active: currentRoute === 'annonces' }">
            <NuxtLink to="/annonces">Annonces</NuxtLink>
            <span class="active-dot" v-if="currentRoute === 'annonces'"></span>
          </li>
          <li class="nav-item" :class="{ active: currentRoute === 'plan' }">
            <NuxtLink to="/plan">Plan</NuxtLink>
          </li>
          <li class="nav-item" :class="{ active: currentRoute === 'chats' }">
            <NuxtLink to="/chats">Chats</NuxtLink>
          </li>
        </ul>
      </nav>
      
      <div class="user-actions">
        <div class="notification-badge">
          <span class="notification-count">0</span>
          <Icon name="mdi:star" class="notification-icon" />
        </div>
        <button class="menu-button">
          <Icon name="mdi:menu" class="menu-icon" />
        </button>
      </div>
    </header>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import { useRoute } from 'vue-router';
  
  const route = useRoute();
  const currentRoute = computed(() => {
    return route.path.split('/')[1] || 'filtres';
  });
  </script>
  
  <style scoped>
  .header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #f0f0f0;
    padding: 0 20px;
    height: 60px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  }
  
  .logo-container {
    display: flex;
    align-items: center;
  }
  
  .logo {
    display: flex;
    align-items: center;
    color: #0a4333;
    font-weight: bold;
    font-size: 1.2rem;
  }
  
  .logo-icon {
    color: #0a4333;
    margin-right: 8px;
    font-size: 1.5rem;
  }
  
  .navigation {
    flex-grow: 1;
    display: flex;
    justify-content: center;
  }
  
  .nav-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 25px;
  }
  
  .nav-item {
    position: relative;
    padding: 5px 0;
  }
  
  .nav-item a {
    color: #333;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.2s;
  }
  
  .nav-item.active a {
    color: #0a4333;
    font-weight: 500;
  }
  
  .active-dot {
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 5px;
    height: 5px;
    background-color: #0a4333;
    border-radius: 50%;
  }
  
  .user-actions {
    display: flex;
    align-items: center;
    gap: 15px;
  }
  
  .notification-badge {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .notification-count {
    font-size: 0.8rem;
    margin-right: 5px;
  }
  
  .notification-icon {
    color: #0a4333;
    font-size: 1.2rem;
  }
  
  .menu-button {
    background: #0a4333;
    color: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }
  
  .menu-icon {
    font-size: 1.3rem;
  }
  .nav-item a {
  font-family: 'Gilgan', sans-serif;
  font-size: 1.1rem;
  font-weight: normal;
}

  </style>