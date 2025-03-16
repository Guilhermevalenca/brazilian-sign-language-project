<template>
  <header>
    <nav class="tw-flex tw-items-center tw-justify-center tw-gap-4">
      <NuxtLink to="/">Home</NuxtLink>
      <NuxtLink to="/sign">Signs</NuxtLink>
      <span v-if="showOptionsAuth" class="tw-flex tw-items-center tw-justify-center tw-gap-4">
        <NuxtLink to="/auth/login">Login</NuxtLink>
        <NuxtLink to="/auth/register">Register</NuxtLink>
      </span>
      <span v-else>
        <button @click="logout">Logout</button>
      </span>
    </nav>
  </header>
</template>

<script lang="ts">
import AuthService from '~/services/AuthService';
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
  name: 'AppHeader',

  data() {
    return {
      userStore: useUserStore(),
      showOptionsAuth: true,
    }
  },

  methods: {
    async logout() {
      await AuthService.logout(this.$axios);
      this.userStore!.resetDatas();
      this.$router.push('/auth/login');
    }
  },

  watch: {
    userStore: {
      handler($new) {
        console.log('atualizado no computed');
        this.showOptionsAuth = !$new?.data?.id;
      },
      deep: true
    }
  }
});
</script>
