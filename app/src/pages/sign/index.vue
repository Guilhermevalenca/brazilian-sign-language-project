<template>
    <div v-if="userStore && userStore.is_admin">
        <button @click="$router.push('/sign/create')">Adicionar Sinal</button>
    </div>
    <div>
        <button @click="previousPage" :disabled="page === 1">previous page</button>
        <button @click="nextPage" :disabled="page === last_page">next page</button>
    </div>
    <div v-for="sign in signs" :key="sign.id">
        <fieldset>
            <pre>{{ sign }}</pre>
            <NuxtLink :to="`/sign/${sign.id}`">ver sinal</NuxtLink>
        </fieldset>
    </div>
</template>

<script lang="ts">
import Sign, { type SignType } from '~/classes/Sign';
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
    name: 'signPage',

    async setup() {
        const { $axios } = useNuxtApp();
        const { data } = await $axios.get('/api/signs');

        return {
            last_page: ref(data.last_page),
            page: ref(1),
            signs: ref(data.data.map((sign: SignType) => new Sign(sign))),
        }
    },

    data() {
        return {
            userStore: null as null | ReturnType<typeof useUserStore>,
        }
    },

    methods: {
        async nextPage() {
            const { data } = await this.$axios.get('/api/signs', {
                params: {
                    page: ++this.page
                }
            });
            this.last_page = data.last_page;
            this.signs = data.data.map((sign: SignType) => new Sign(sign));
        },
        
        async previousPage() {
            const { data } = await this.$axios.get('/api/signs', {
                params: {
                    page: --this.page
                }
            });
            this.last_page = data.last_page;
            this.signs = data.data.map((sign: SignType) => new Sign(sign));
        }
    },

    mounted() {
        this.userStore = useUserStore();
    }
});
</script>