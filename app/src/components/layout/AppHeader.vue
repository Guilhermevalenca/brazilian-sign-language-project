<template>
  <header>
    <div class="header-content">
      <div class="logo tw-cursor-pointer" @click="navigateTo('/')">
        <img
          src="~/assets/logos/our-logo.svg"
          width="278px"
          height="68px"
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
  </header>
</template>

<script lang="ts">
import AuthService from '~/services/AuthService';
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
  name: 'AppHeader',
  data() {
    return {
      userStore: null as null | ReturnType<typeof useUserStore>,
    };
  },

  methods: {
    async logout() {
      await AuthService.logout();
      this.userStore!.resetDatas();
      navigateTo('/auth/login');
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
  height: auto;
  top: 0;
  position: fixed;
  z-index: 1000;
  width: 100%;
  box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
}
.header-content {
  display: grid;
  grid-template-columns: repeat(3,auto);
  box-sizing: border-box;
  height: 5.4rem;
  align-items: center;
  align-content: center;
  padding: 1rem 2rem;
  background-color: $primary-color;
}
.auth-container {
  display: flex;
  justify-content: flex-end;
  flex-flow: row nowrap;
  gap: 1rem;
}
button {
  background: none;
  border: none;
  padding: 0;
  margin: 0;
  cursor: pointer;
}
.user-avatar {
  cursor: pointer;
  display: flex;
  flex-flow: row wrap;
  align-items: center;
  align-content: center;
  justify-content: center;
  padding: 0.5rem;
  border: solid 1px white;
  border-radius: 0.5rem;
  color: white;
}
.auth-control-panel {
  display: flex;
  gap: 1rem;
  flex-flow: row nowrap;
  align-items: center;
  align-content: center;
  justify-content: center;
}
</style>