<template>
  <nav class="menu-container-closed" tabindex="0"  :class="{'menu-container-open': isVisible}" ref="menuContainer">
    <button @click="navigateTo('/')">
      <img src="~/assets/icons/home.svg" width="24px" height="24px">
      <span v-show="isVisible">Inicio</span>
    </button>
<!--    <button @click="navigateTo('/favorite')">-->
<!--      <img src="~/assets/icons/favorite.svg" width="24px" height="24px">-->
<!--      <span v-show="isVisible">Favoritos</span>-->
<!--    </button>-->
    <button @click="navigateTo('/about')">
      <img src="~/assets/icons/info.svg" width="24px" height="24px">
      <span v-show="isVisible">Sobre nós</span>
    </button>
  </nav>
</template>

<script lang="ts">
export default {
  name: "Menu",
  props:{
    isVisible: Boolean,
  },
}
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
  gap: 5em;
  height: 100vh;
  width: 5em;
  margin:0;
  position: absolute;
  padding: 2em 0em;
  box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
}
.menu-container-open{
  width: 14em;
}
button{
  width: 100%;
  padding:1em 2em;
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