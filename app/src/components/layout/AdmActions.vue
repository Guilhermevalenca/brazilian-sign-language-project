<template>
  <div class="adm-actions-container" ref="menuContainer">
    <button class="adm-actions-button" @click="showOptionsAdm()">
      <img src="../../assets/icons/plus.svg" width="50px" height="50px">
    </button>
    <div class="adm-actions-options" v-if="showOptions">
      <button type="button" @click="$router.push('/courses/create'); selectOption()">Adicionar Curso</button>
      <button type="button" @click="$router.push('/sign/index'); selectOption()" >Adicionar Sinal</button>
      <button type="button" @click="$router.push('/subjects/create'); selectOption()">Adicionar Matéria</button>
    </div>
  </div>
</template>

<script lang="ts">

export default{
  name: "AdmActions",
  data(){
    return{
      showOptions: false,
    }
  },
  methods:{
    showOptionsAdm(){
      this.showOptions = !this.showOptions
    },
    closeMenu(event: MouseEvent) {
      const menu = this.$refs.menuContainer as HTMLElement;
      if (menu && !menu.contains(event.target as Node)) {
        this.showOptions = false;
      }
    },
    selectOption(){
      this.showOptions = false;
    }
  },
  mounted() {
    document.addEventListener("click", this.closeMenu);
  },
  beforeUnmount() {
    document.removeEventListener("click", this.closeMenu);
  },
}
</script>

<style scoped lang="scss">
.adm-actions-container{
  display: flex;
  flex-direction: column-reverse;
  align-items: center;
  position: fixed;
  padding:1em;
  bottom: 2em;
  right: 4em;
}
.adm-actions-button{
  background-color: $secondary-color;
  border: none;
  width: 6em;
  height: 6em;
  border-radius: 3em;
  position: relative;
}
.adm-actions-options{
  border-radius: 1em;
  display: flex;
  flex-direction: column;
  text-wrap: nowrap;
  background-color: $primary-color;
  position: absolute;
  bottom: 6.5em;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
  button{
    color: $tertiary-color;
    background-color: transparent;
    border-radius: 1em;
    border-color: transparent;
    cursor: pointer;
    padding:1em;
  }
  button:hover{
    justify-self: center;
    transform: scale(1.1,1.1);
    background-color: $primary-color-hovered;
  }
}
</style>