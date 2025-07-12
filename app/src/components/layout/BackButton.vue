<template>
  <div>
    <AppButton variant="navigation" @click="back()">
      <img src="~/assets/icons/arrow-left.svg" width="24" height="24" alt="Voltar" />
      Voltar
    </AppButton>
  </div>
</template>

<script setup lang="ts">
const router = useRouter();

function back() {
  if (window.history.length > 1) {
    router.back();
  } else {
    navigateTo('/');
  }
}
</script>

<style scoped lang="scss">
div {
  margin: 0.6em;
}
</style>
