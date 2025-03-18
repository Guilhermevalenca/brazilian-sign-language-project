<template>
  <header class="header-container">
    <button @click="showMenu()">
      <img src="~/assets/icons/menu.svg" width="24px" height="24px">
    </button>
    <button>
      <img src="../assets/icons/our-logo.svg" width="288px" height="78px">
    </button>

    <div class="auth-container">
      <ButtonApp variant="default"> Login </ButtonApp>
      <ButtonApp varaiant="default"> Cadastre-se </ButtonApp>
    </div>
    <slot />
  </header>
  <Menu :isVisible="isVisibleHere"/>
</template>

<script lang="ts">
import AuthService from '~/services/AuthService';
import useUserStore from '~/stores/useUserStore';
import Menu from "./Menu.vue";

export default defineComponent({
  name: 'AppHeader',
  components:{
    Menu
  },
  data() {
    return {
      userStore: useUserStore(),
      showOptionsAuth: true,
      isVisibleHere: false
    }
  },

  methods: {
    async logout() {
      await AuthService.logout();
      this.userStore!.resetDatas();
      this.$router.push('/auth/login');
    },
    showMenu(){
    if(this.isVisibleHere == false){
      this.isVisibleHere = true
    }else{
      this.isVisibleHere = false
    }
    }
  },

  watch: {
    userStore: {
      handler($new) {
        this.showOptionsAuth = !$new?.data?.id;
      },
      deep: true
    }
  }
});
</script>
<style scoped>
.header-container{
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content:flex-start;
  align-items: center;
  gap: 2em;
  padding: 0.5em 2em;
  background-color: #2F9E41;
}
.auth-container{
  display:flex;
  margin-left: auto;
  gap:1em;
}
button {
  background: none;
  border: none;
  padding: 0;
  margin: 0;
  cursor: pointer;
}
</style>