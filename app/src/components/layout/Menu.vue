<template>
  <nav
<<<<<<< HEAD
      class="menu-container-closed" tabindex="0"
      :class="{'menu-container-open':hovering}"
      ref="menuContainer"
      @mouseenter="hovering = true"
      @mouseleave="hovering = false"
  >
    <button title="Início" @click="navigateTo('/')">
      <img src="~/assets/icons/home.svg" width="24px" height="24px">
      <span v-show="hovering">Inicio</span>
=======
    class="menu-container-closed"
    tabindex="0"
    ref="menuContainer"
    :class="{ 'menu-container-open': props.isVisible }"
  >
    <button title="Início" @click="navigateTo('/')">
      <img src="~/assets/icons/home.svg" width="24px" height="24px" alt="Página inicial" />
      <span v-show="props.isVisible">Inicio</span>
>>>>>>> origin/feature/adding-optimize-app-and-correction-bug
    </button>
    <!--    <button @click="navigateTo('/favorite')">-->
    <!--      <img src="~/assets/icons/favorite.svg" width="24px" height="24px">-->
    <!--      <span v-show="props.isVisible">Favoritos</span>-->
    <!--    </button>-->
    <button title="Sobre nós" @click="navigateTo('/about')">
<<<<<<< HEAD
      <img src="~/assets/icons/info.svg" width="24px" height="24px">
      <span v-show="hovering">Sobre nós</span>
=======
      <img src="~/assets/icons/info.svg" width="24px" height="24px" alt="Sobre nós" />
      <span v-show="props.isVisible">Sobre nós</span>
    </button>
    <button v-if="userStore.is_admin" title="Gráficos" @click="navigateTo('/monitoring')">
      <img src="~/assets/icons/chart-bar.svg" width="24px" height="24px" alt="Gráficos" />
      <span v-show="props.isVisible">Gráficos</span>
>>>>>>> origin/feature/adding-optimize-app-and-correction-bug
    </button>
  </nav>
</template>

<script setup lang="ts">
<<<<<<< HEAD
import { ref } from 'vue'
const hovering = ref(false)
=======
import useUserStore from '~/stores/useUserStore';

const userStore = useUserStore();
const props = defineProps({
  isVisible: Boolean,
});
>>>>>>> origin/feature/adding-optimize-app-and-correction-bug
</script>

@import
url('https://fonts.googleapis.com/css2?family=Quantico:ital,wght@0,400;0,700;1,400;1,700&display=swap');

<style scoped lang="scss">
.menu-container-closed {
  background-color: $primary-color;
  display: flex;
  flex-direction: column;
  flex-wrap: nowrap;
  align-self: flex-start;
  align-items: center;
  justify-content: flex-start;
  position: fixed;
  left: 0;
  width: 5em;
<<<<<<< HEAD
  margin:0;
  height: 100vh;
=======
  margin: 0;
  position: absolute;
>>>>>>> origin/feature/adding-optimize-app-and-correction-bug
  padding: 0em 0em;
  box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
}
.menu-container-open {
  width: 14em;
}
button {
  width: 100%;
  padding: 2em 2em;
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
button:hover {
  background-color: $primary-color-hovered;
}
</style>
