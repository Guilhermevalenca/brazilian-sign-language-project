<template>
  <div>
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>

  <input v-model="user.name" />
  <pre>
    {{ user }}
  </pre>
  <button @click="user.alterLoading">teste</button>
</template>


<script lang="ts">
import useUserStore from '~/stores/useUserStore';
import User from './classes/User';
export default defineComponent({
  name: 'App',

  data() {
    return {
      user: new User({})
    }
  },

  mounted() {
    if(localStorage.getItem('token')) {
      this.$axios.defaults.headers
          .common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

      useUserStore().data.fetch(this.$axios);
    }

    this.$axios.get('/sanctum/csrf-cookie');
  }
});
</script>