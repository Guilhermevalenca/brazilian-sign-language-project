<template>
  <!-- Menu fechado -->
<nav class="menu-container-closed">
  <button>
    <img src="~/assets/icons/home.svg" width="24px" height="24px">
  </button>
  <button>
    <img src="~/assets/icons/favorite.svg" width="24px" height="24px">
  </button>
  <button>
    <img src="~/assets/icons/info.svg" width="24px" height="24px">
  </button>
</nav>
<!-- Menu aberto -->
  <nav class="menu-container-open" v-show="isVisible">
    <a><img src="~/assets/icons/home.svg" width="24px" height="24px"> Inicio </a>
    <a><img src="~/assets/icons/favorite.svg" width="24px" height="24px">Favoritos</a>
    <a><img src="~/assets/icons/info.svg" width="24px" height="24px">Sobre nós</a>
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

<style scoped>
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
  background-color: #2F9E41;
  display:flex;
  flex-direction: column;
  flex-wrap: wrap;
  align-self: flex-start;
  align-items: center;
  justify-content: flex-start;
  gap: 5em;
  height: 100vh;
  width: 10em;
  padding: 2em 2em;
  margin:0;
  position: fixed;
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
}
button{
  background: none;
  border: none;
  padding: 0;
  margin: 0;
  cursor: pointer;
}
</style>