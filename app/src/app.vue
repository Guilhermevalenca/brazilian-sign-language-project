<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>


<script lang="ts">
import useUserStore from '~/stores/useUserStore';
import UserService from "~/services/UserService";
import type { UserType } from '~/types/User';

export default defineComponent({
  name: 'App',

  async setup() {
    const token = useCookie('token');
    if(token) {
      try {
        const { data } = await UserService.fetch();
        return {
          user: data
        }
      } catch(error) {
        token.value = null;
        return {
          user: null
        }
      }
    }
    return {
      user: null as null | UserType
    }
  },

  mounted() {
    const user = useUserStore();
    if(this.user) {
      user.data = this.user;
      Promise.all([
        user.fetchIsAdmin(),
        this.$axios.get('/sanctum/csrf-cookie'),
      ]);
    }

  },
});
</script>

<style>
*{
  margin:0;
  padding: 0;
}
</style>