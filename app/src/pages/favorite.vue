<template>
  <div>Seus favoritos</div>
</template>

<script lang="ts">
export default defineComponent({
    name: 'favoritesPage',

    async setup() {
        definePageMeta({
            middleware: 'auth',
        });
    },
});
</script>