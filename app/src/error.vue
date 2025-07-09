<script setup lang="ts">
import type { NuxtError } from '#app';

const props = defineProps({
  error: {
    type: Object as PropType<NuxtError>,
  }
});

function handleError() {
  clearError({ redirect: '/' });
}
</script>

<template>
  <section>
    <div>
      <h1>Algo deu errado</h1>
      <h2>{{ error?.statusCode }}</h2>
      <AppButton @click="handleError">Voltar para a pagina inicial</AppButton>
    </div>
  </section>
</template>

<style scoped>
section {
  display: flex;
  min-width: 100vw;
  min-height: 100vh;

  justify-content: center;
  align-items: center;
  text-align: center;
}
</style>
