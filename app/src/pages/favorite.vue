<template>
<client-only>
    <pre>{{ userStore?.data.getFavorites() }}</pre>
</client-only>
</template>


<script lang="ts">
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
    name: 'favoritesPage',

    async setup() {
        definePageMeta({
            middleware: 'auth',
        });
    },

    data: () => ({
        userStore: null,
    }),

    mounted() {
        this.userStore = useUserStore();

        this.userStore?.data.fetchFavorites();
    },
});
</script>