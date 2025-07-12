<template>
  <div>Seus favoritos</div>
</template>

<script lang="ts">
export default defineComponent({
  name: 'FavoritesPage',

  async setup() {
    definePageMeta({
      middleware: 'auth',
    });
  },
});
</script>
