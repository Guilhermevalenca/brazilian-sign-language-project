<template>
  <nav
      class="menu-container-closed" tabindex="0"
      :class="{'menu-container-open':hovering}"
      ref="menuContainer"
      @mouseenter="hovering = true"
      @mouseleave="hovering = false"
  >
    <button title="Início" @click="navigateTo('/')">
      <img src="~/assets/icons/home.svg" width="24px" height="24px">
      <span v-show="hovering">Inicio</span>
    </button>
<!--    <button @click="navigateTo('/favorite')">-->
<!--      <img src="~/assets/icons/favorite.svg" width="24px" height="24px">-->
<!--      <span v-show="isVisible">Favoritos</span>-->
<!--    </button>-->
    <button title="Sobre nós" @click="navigateTo('/about')">
      <img src="~/assets/icons/info.svg" width="24px" height="24px">
      <span v-show="hovering">Sobre nós</span>
    </button>
  </nav>
</template>

<script setup lang="ts">
import { ref } from 'vue'
const hovering = ref(false)
</script>
@import url('https://fonts.googleapis.com/css2?family=Quantico:ital,wght@0,400;0,700;1,400;1,700&display=swap');

<style scoped lang="scss">
.menu-container-closed{
  background-color: $primary-color;
  display:flex;
  flex-direction: column;
  flex-wrap: nowrap;
  align-self: flex-start;
  align-items: center;
  justify-content: flex-start;
  position: fixed;
  left: 0;
  width: 5em;
  margin:0;
  height: 100vh;
  padding: 0em 0em;
  box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
}
.menu-container-open{
  width: 14em;
}
button{
  width: 100%;
  padding:2em 2em;
  font-size: 1rem;
  font-weight: bold;
  color: $tertiary-color;
  display: flex;
  align-self: flex-start;
  align-items: center;
  flex-direction: row;
  gap: 2em;
  background-color: transparent;
  border: none;
  cursor: pointer;
}
button:hover{
  background-color: $primary-color-hovered;
}
</style>