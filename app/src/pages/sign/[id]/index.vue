<template>
    <button @click="$router.push(`/sign/${sign.id}/update`)">Atualizar</button>
    <br />
    <button @click="destroy">deletar ou apagar</button>
    <span class="tw-text-xs">*Esta opção apagará o contéudo para sempre</span>
    <br />
    <iframe
        :src="sign.display"
        frameborder="0"
        allowfullscreen
    >
    </iframe>
    <pre>{{ sign }}</pre>
</template>

<script lang="ts">
import Sign from '~/classes/Sign';

export default defineComponent({
    name: 'signPage',

    async setup() {
        const { $axios } = useNuxtApp();
        const { id } = useRoute().params;
        const { data } = await $axios.get(`/api/signs/${id}`);

        const sign = new Sign(data);

        if(data.example) {
            sign.setExample(data.example);
        }
        if(data.description) {
            sign.setDescription(data.description);
        }

        return {
            sign,
        }
    },

    methods: {
        async destroy() {
            try {
                await this.sign.delete(this.$axios);
                this.$router.push('/sign');
            } catch(e) {
                console.log(e);
            }
        }
    }
});
</script>