<template>
<nav class="menu-container-closed" :class="{'menu-container-open': isVisible}">
  <a @click="$router.push('/')">
    <img src="~/assets/icons/home.svg" width="24px" height="24px">
    <span v-show="isVisible">Inicio</span>
  </a>
  <a @click="$router.push('/favorite')">
    <img src="~/assets/icons/favorite.svg" width="24px" height="24px">
    <span v-show="isVisible">Favoritos</span>
  </a>
  <a @click="$router.push('/about')">
    <img src="~/assets/icons/info.svg" width="24px" height="24px">
    <span v-show="isVisible">Sobre nós</span>
  </a>
</nav>
</template>

<script lang="ts">
export default {
  name: "Menu",
  props:{
    isVisible: Boolean,
  }
}
</script>
@import url('https://fonts.googleapis.com/css2?family=Quantico:ital,wght@0,400;0,700;1,400;1,700&display=swap');

<style scoped lang="scss">
.menu-container-closed{
  background-color: #2F9E41;
  display:flex;
  flex-direction: column;
  flex-wrap: wrap;
  align-self: flex-start;
  align-items: center;
  justify-content: flex-start;
  gap: 5em;
  height: 100vh;
  width: 1em;
  padding: 2em 2em;
  margin:0;
  position: fixed;
}
.menu-container-open{
  width: 10em;
}
a{
  font-family: Quantico;
  font-size: 1rem;
  font-weight: bold;
  color: #FFFFFF;
  display: flex;
  align-self: flex-start;
  align-items: center;
  flex-direction: row;
  gap: 2em;

  &:hover{
    cursor: pointer;
  }
}
</style>