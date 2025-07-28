<template>
  <nav
    class="menu-container-closed"
    :class="{ 'menu-container-open': isHovering }"
    tabindex="0"
    @mouseenter="isHovering=true"
    @mouseleave="isHovering=false"
  >
    <button title="Início" @click="navigateTo('/')">
      <img src="~/assets/icons/home.svg" width="24px" height="24px" alt="Página inicial" />
      <span v-if="isHovering">Inicio</span>
    </button>
    <!--    <button @click="navigateTo('/favorite')">-->
    <!--      <img src="~/assets/icons/favorite.svg" width="24px" height="24px">-->
    <!--      <span v-show="props.isVisible">Favoritos</span>-->
    <!--    </button>-->
    <button title="Sobre nós" @click="navigateTo('/about')">
      <img src="~/assets/icons/info.svg" width="24px" height="24px" alt="Sobre nós" />
      <span v-if="isHovering">Sobre nós</span>
    </button>
    <button v-if="userStore.is_admin" title="Gráficos" @click="navigateTo('/monitoring')">
      <img src="~/assets/icons/chart-bar.svg" width="24px" height="24px" alt="Gráficos" />
      <span v-if="isHovering">Gráficos</span>
    </button>
  </nav>
</template>

<script setup lang="ts">
import useUserStore from '~/stores/useUserStore';
import { ref } from 'vue';

const isHovering = ref(false)
const userStore = useUserStore();

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
  height: 100vh;
  width: 5em;
  margin: 0;
  top: 5em;
  position: fixed;
  padding: 0em 0em;
  box-shadow: 2px 2px 4px 0 rgba(0, 0, 0, 0.2);
  z-index: 1001;
}
.menu-container-open {
  width: 14em;
  z-index: 1001;
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
