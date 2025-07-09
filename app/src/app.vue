<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup lang="ts">
import useUserStore from '~/stores/useUserStore';
import UserService from '~/services/UserService';

const userStore = useUserStore();
const token = useCookie('token').value;
if (token) {
  try {
    const { data } = await UserService.fetch();
    userStore.data = data;
  } catch (error) {
    userStore.data = null;
  }
}
const { $axios } = useNuxtApp();
onMounted(() => {
  Promise.all([userStore.fetchIsAdmin(), $axios.get('/sanctum/csrf-cookie')]);
});

onBeforeMount(() => {
  //removendo scrollbar horizontal
  // document.body.style.overflowX = 'hidden';
});
</script>
