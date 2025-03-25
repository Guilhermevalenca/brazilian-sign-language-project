<template>
  <div>
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>


<script lang="ts">
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
  name: 'App',

  async mounted() {
    if(localStorage.getItem('token')) {
      this.$axios.defaults.headers
          .common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

      useUserStore().data.fetch()
        .then(() => {
          if(useUserStore().data.id) {
            useUserStore().fetchIsAdmin();
          }
        })
        .catch((err) => {
          if(err.response.status === 401) {
            useUserStore().resetDatas();
            localStorage.removeItem('token');
            delete this.$axios.defaults.headers.common['Authorization'];
            const tokenCookie = useCookie('token');
            tokenCookie.value = null;
          }
        })
    }

    this.$axios.get('/sanctum/csrf-cookie');
  },
});
</script>

<style>
*{
  margin:0;
  padding: 0;
}
</style>