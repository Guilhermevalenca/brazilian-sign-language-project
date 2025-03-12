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

  mounted() {
    if(localStorage.getItem('token')) {
      this.$axios.defaults.headers
          .common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

      useUserStore().data.fetch(this.$axios);
    }

    this.$axios.get('/sanctum/csrf-cookie');
  },
});
</script>