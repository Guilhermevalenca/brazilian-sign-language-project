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
          <AppTextarea v-model="sign.description!.text" placeholder="Escreva uma descrição para o sinal"></AppTextarea>
          <AppInput type="link" v-model="sign.description!.display" placeholder="Link do video"/>
          <small>Apenas links do youtube</small>
        </label>

        <label>Exemplo de uso do sinal <span class="tw-text-xs">*Campos não obrigatorios</span>
          <AppTextarea v-model="sign.example!.description" placeholder="Escreva uma descrição para uso" />
          <AppInput type="link" v-model="sign.example!.display" placeholder="Link do video" />
          <small>Apenas links do youtube</small>
        </label>
        <legend>Palavras-chave</legend>
        <KeywordSelect
            v-model="sign.keywords"
        />
        {{ sign.keywords }}
      <AppButton type="submit">Criar sinal</AppButton>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import SignService from '~/services/SignService';
import type { SignType } from '~/types/Sign';

export default defineComponent({
    name: 'signCreatePage',

    async setup() {
        definePageMeta({
            middleware: 'is-admin',
        })
    },

    data: () => ({
      sign: {
        name: '',
        display: '',
        description: {
            text: '',
            display: '',
        },
        example: {
            description: '',
            display: '',
        },
        keywords: []
      },
    }),

    methods: {
        async submit() {
            try {
              const sign: SignType = {...this.sign};
              if(sign.example?.description === '' || sign.example?.display === '') {
                delete sign.example;
              }
              if(sign.description?.text === '' || sign.description?.display === '') {
                delete sign.description;
              }
              await SignService.create(sign);
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