<template>
    <form @submit.prevent="submit">
        <div>
            <label>informações do sinal</label>
            <br />
            <input v-model="sign.name" placeholder="Nome do sinal">
            <br />
            <input v-model="sign.display" placeholder="Link do video">
            <small>Apenas links do youtube</small>
        </div>
        <br />
        <div>
            <label>descrição do sinal <span class="tw-text-xs">* Campos não obrigatorios</span></label>
            <br />
            <textarea v-model="sign.getDescription()!.text" placeholder="Descrição do sinal"></textarea>
            <br />
            <input v-model="sign.getDescription()!.display" placeholder="Video descrevendo o sinal">
            <small>Apenas links do youtube</small>
        </div>
        <br />
        <div>
            <label>Exemplo de uso do sinal <span class="tw-text-xs">* Campos não obrigatorios</span></label>
            <br />
            <input v-model="sign.getExample()!.description" placeholder="descrição do exemplo" />
            <br />
            <input v-model="sign.getExample()!.display" placeholder="link do exemplo" />
            <small>Apenas links do youtube</small>
        </div>
        <br />
        <div>
            <label>Palavras-chave do sinal </label>
            <br />
            <SignKeywordSelect
                v-model="keywords"
            />
        </div>
        <br />
        <br />
        <button type="submit">criar sinal</button>
    </form>
</template>

<script lang="ts">
import type Keyword from '~/classes/Keyword';
import Sign from '~/classes/Sign';

export default defineComponent({
    name: 'signCreatePage',

    async setup() {
        definePageMeta({
            middleware: 'is-admin',
        })
    },

    data() {
        const sign = new Sign({
            name: '',
            display: ''
        });

        sign.setExample();
        sign.setDescription();

        return {
            sign,
            keywords: [] as Keyword[],
        }
    },

    methods: {
        async submit() {
            try {
                if(!this.sign.getExample()?.description || !this.sign.getExample()?.display) {
                    this.sign.resetExample();
                }
                if(!this.sign.getDescription()?.text || !this.sign.getDescription()?.display) {
                    this.sign.resetDescription();
                }
                this.sign.setKeywords(this.keywords);
                await this.sign.register()
                    .then(res => {
                        console.log(res);
                    })
                // this.$router.push('/sign');
            } catch (e) {
                console.log(e);
            }
        }
    }
});
</script>