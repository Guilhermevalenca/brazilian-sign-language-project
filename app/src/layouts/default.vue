<template>
  <LayoutAppHeader />
  <main>
    <section>
      <slot />
    </section>
  </main>
  <AdmActions/>
  <LayoutAppFooter />
</template>
<style lang="scss" scoped>

section {
  margin: 0 auto;
  width: 60vw;
  margin-top: 8em;
  overflow-y: auto;
}
</style>
<script setup lang="ts">
import AdmActions from "~/components/layout/AdmActions.vue";
</script>