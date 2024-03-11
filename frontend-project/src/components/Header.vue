<template>
    <header>
        <div class="container-fluid container-fluid-header bg-primary">
            <nav class="top-navbar d-flex justify-content-center">
            <RouterLink class="header-link" to="/">Home</RouterLink>
            <RouterLink class="header-link" to="/about">Sobre</RouterLink>
            <RouterLink class="header-link" to="/login">Login</RouterLink>
            </nav>
        </div>
    </header>
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'

</script>

<style scoped>
  .container-fluid-header {
    padding: 0;
  }
  .top-navbar {
    
  }
  .header-link {
    padding: 1em;
    color: #FFFFFF;
    text-decoration: none;
    margin: 0;
  }
  .header-link:hover {
    color: lightyellow;
  }
</style>