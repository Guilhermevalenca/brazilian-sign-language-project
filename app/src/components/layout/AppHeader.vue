<template>
  <header>
    <div class="header-content">
      <div>
        <button @click="showMenu()">
          <img src="~/assets/icons/menu.svg" width="24px" height="24px" alt="Menu" />
        </button>
      </div>
      <div class="logo tw-cursor-pointer" @click="navigateTo('/')">
        <img
          src="~/assets/logos/our-logo.svg"
          width="288px"
          height="78px"
          alt="Logo do glossário de libras"
        />
      </div>
      <SearchingBar />
      <div v-if="!userStore?.data" class="auth-container">
        <AppButton variant="default" @click="navigateTo('/auth/login')"> Login </AppButton>
        <AppButton varaiant="default" @click="navigateTo('/auth/register')">
          Cadastre-se
        </AppButton>
      </div>
      <div class="auth-control-panel" v-else>
        <div class="user-avatar" @click="navigateTo('/profile')">
          <span>{{ userStore.data?.name }}</span>
        </div>
        <AppButton variant="default" @click="logout">Desconectar</AppButton>
      </div>
    </div>
    <section>
      <Menu :isVisible="isVisibleHere" />
    </section>
  </header>
</template>

<script lang="ts">
import AuthService from '~/services/AuthService';
import useUserStore from '~/stores/useUserStore';
import Menu from './Menu.vue';

export default defineComponent({
  name: 'AppHeader',
  components: {
    Menu,
  },
  data() {
    return {
      userStore: null as null | ReturnType<typeof useUserStore>,
      isVisibleHere: false,
    };
  },

  methods: {
    async logout() {
      await AuthService.logout();
      this.userStore!.resetDatas();
      navigateTo('/auth/login');
    },
    showMenu() {
      this.isVisibleHere = !this.isVisibleHere;
    },
  },

  mounted() {
    this.userStore = useUserStore();
  },
});
</script>
<style lang="scss" scoped>
div {
  display: flex;
  flex: auto;
}
header {
  box-sizing: border-box;
  flex-flow: row wrap;
  top: 0;
  z-index: 0;
  position: fixed;
  width: 100%;
  box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
}
.header-content {
  box-sizing: border-box;
  display: flex;
  flex: auto;
  flex-flow: row nowrap;
  justify-content: space-around;
  align-items: center;
  align-content: stretch;
  padding: 0.5rem 2rem;
  background-color: $primary-color;
}
.auth-container {
  display: flex;
  justify-content: flex-end;
  padding: 0 2rem;
  flex: auto;
  flex-flow: row wrap;
  gap: 1em;
}
button {
  background: none;
  border: none;
  padding: 0;
  margin: 0;
  cursor: pointer;
}
.user-avatar {
  display: flex;
  flex-flow: row wrap;
  align-items: center;
  align-content: center;
  justify-content: center;
  padding: 0.5em;
  border: solid 1px white;
  border-radius: 0.5em;
  color: white;
}
.auth-control-panel {
  display: flex;
  gap: 1em;
  flex-flow: row wrap;
  align-items: center;
  align-content: center;
  justify-content: center;
}
</style>
