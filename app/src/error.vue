<script lang="ts">
import type { NuxtError } from '#app'

export default defineComponent({
    name: "error",

    props: {
        error: Object as () => NuxtError
    },

    methods: {
        handleError() {
            clearError({ redirect: '/' })
        }
    }
});
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