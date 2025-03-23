<template>
  <div class="app-header">
    <header class="header-container">
      <button @click="showMenu()">
        <img src="~/assets/icons/menu.svg" width="24px" height="24px">
      </button>
      <button @click="$router.push('/')">
        <img src="~/assets/logos/our-logo.svg" width="288px" height="78px">
      </button>
      <SearchingBar/>
      <div class="auth-container">
        <AppButton variant="default" @click="$router.push('/auth/login')"> Login </AppButton>
        <AppButton varaiant="default" @click="$router.push('/auth/register')"> Cadastre-se </AppButton>
      </div>
    </header>
    <Menu :isVisible="isVisibleHere" />
  </div>
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
      userStore: null as null | ReturnType<typeof useUserStore>,
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
      this.isVisibleHere = !this.isVisibleHere;
    }
  },

  watch: {
    userStore: {
      handler($new) {
        this.showOptionsAuth = !$new?.data?.id;
      },
      deep: true
    }
  },

  mounted() {
    this.userStore = useUserStore();
  }
});
</script>
<style scoped>
.app-header {
  position: fixed;
  top: 0;
  width: 100vw;
}
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