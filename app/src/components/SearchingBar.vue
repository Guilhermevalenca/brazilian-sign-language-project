<template>
  <div class="searching-bar-container">
    <input class="searching-bar-input" type="text" placeholder="Buscar ...">
    <button class="search-settings">
      <img src="~/assets/icons/settings.svg" width="24px" height="24px">
    </button>
    <button class="search-button">
      <img src="~/assets/icons/search.svg" width="24px" height="24px">
    </button>
  </div>
</template>

<script lang="ts">

export default{
  name: "SearchingBar"
}
</script>

<style scoped>
.searching-bar-container{
  display: flex;
  align-items: center;
  justify-self: center;
  margin-left: auto;
}
.searching-bar-input{
  border: none;
  border-top-left-radius: 5em;
  border-bottom-left-radius: 5em;
  padding: 0em 2em;
  width: 30em;
  height: 4em;
}
.search-button{
  background-color: #2266D2;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  border-top-right-radius: 50%;
  border-bottom-right-radius: 50%;
  cursor:pointer;
  width: 4.5em;
  height: 4em;
}
.search-settings{
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  background-color: #FFFFFF;
  cursor: pointer;
  width: 4.5em;
  height: 4em;
}
.searching-bar-input:focus{
  outline: none;
  border: none;
  box-shadow: none;
}

</style>