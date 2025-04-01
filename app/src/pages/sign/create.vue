<template>
  <AppCard>
    <h1>Adicionar sinais</h1>
    <AppForm @submit.prevent="submit">
      <section>
        <legend>Informações do sinal</legend>
        <label>
          Nome:
          <AppInput v-model="sign.name" placeholder="Nome do sinal"/>
        </label>
        <label>
          Link do video:
          <AppInput type="link" v-model="sign.display" placeholder="Link do video"/>
          <small>Apenas links do youtube</small>
        </label>
      </section>

        <label>Descrição do sinal <span class="tw-text-xs">*Campos não obrigatorios</span>
        <AppTextarea v-model="sign.getDescription()!.text" placeholder="Escreva uma descrição para o sinal"></AppTextarea>
        <AppInput type="link" v-model="sign.getDescription()!.display" placeholder="Link do video"/>
        <small>Apenas links do youtube</small>
        </label>

        <label>Exemplo de uso do sinal <span class="tw-text-xs">*Campos não obrigatorios</span>
          <AppTextarea v-model="sign.getExample()!.description" placeholder="Escreva uma descrição para uso" />
          <AppInput type="link" v-model="sign.getExample()!.display" placeholder="Link do video" />
          <small>Apenas links do youtube</small>
        </label>
        <legend>Palavras-chave</legend>
        <LazyKeywordSelect
            v-model="keywords"
        />
      <AppButton type="submit">Criar sinal</AppButton>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import type Keyword from '~/types/Keyword';
import Sign from '~/types/Sign';

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
                this.$router.push('/sign');
            } catch (e) {
                console.log(e);
            }
        }
    }
});
</script>
<style lang="scss">
</style>