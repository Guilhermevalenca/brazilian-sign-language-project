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
    <!-- apenas para listar as informações do objeto -->
    <p>informações:</p>
    <div>
        <fieldset>
            <legend>Sinal</legend>
            <ul>{{ sign.name }}</ul>
            <ul>{{ sign.display }}</ul>
        </fieldset>
        <fieldset>
            <legend>Descrição</legend>
            <ul>{{ sign.description?.text }}</ul>
            <ul>{{ sign.description?.display }}</ul>
        </fieldset>
        <fieldset>
            <legend>Exemplo</legend>
            <ul>{{ sign.example?.description }}</ul>
            <ul>{{ sign.example?.display }}</ul>
        </fieldset>
    </div>
</template>

<script lang="ts">

import SignService from '~/services/SignService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { SignType } from '~/types/Sign';

export default defineComponent({
    name: 'signPage',

    async setup() {
        const { id } = useRoute().params;
        const sign = ref<SignType>({
            name: '',
            display: '',
        })
        async function getSign() {
            const { data } = await SignService.find(Number(id));
            sign.value = data;
        }

        getSign();

        return {
            sign,
            id
        }
    },

    methods: {
        async destroy() {
            try {
                await SignService.delete(Number(this.id));
                this.$router.push('/sign');
            } catch(e) {
                console.log(e);
            }
        }
    },

    watch: {
        "sign.name": {
            handler($new) {
                useBreadcrumbStore().activeSign($new ?? '');
            },
            deep: true,
            immediate: true,
        }
    }
});
</script>