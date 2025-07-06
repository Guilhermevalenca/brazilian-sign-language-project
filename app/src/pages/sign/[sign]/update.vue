<template>
  <AppCard>
    <h1>Atualizar sinal</h1>
    <AppForm @submit.prevent="submit">
      <section>
        <legend>Informações do sinal</legend>
        <label>
          Nome:
          <AppInput
              v-model="sign.name"
              placeholder="Nome do sinal"
              name="sign.name"
          />
        </label>
        <label>
          Link do video:
          <AppInput
              type="link"
              v-model="sign.display"
              placeholder="Link do video"
              name="sign.display"
          />
          <small>Apenas links do youtube</small>
        </label>
      </section>

      <label>Descrição do sinal <span class="tw-text-xs">*Campos não obrigatorios</span>
        <AppTextarea
            v-model="sign.description!.text"
            placeholder="Escreva uma descrição para o sinal"
        />
        <AppInput
            type="link"
            v-model="sign.description!.display"
            placeholder="Link do video"
            name="sign.description.display"
        />
        <small>Apenas links do youtube</small>
      </label>

      <label>Exemplo de uso do sinal <span class="tw-text-xs">*Campos não obrigatorios</span>
        <AppTextarea
            v-model="sign.example!.description"
            placeholder="Escreva uma descrição para uso"
        />
        <AppInput
            type="link"
            v-model="sign.example!.display"
            placeholder="Link do video"
            name="sign.example.display"
        />
        <small>Apenas links do youtube</small>
      </label>

      <legend>Selecione as palavras-chave</legend>
      <KeywordSelect
          v-model="sign.keywords"
      />
      <br />

      <legend>Selecione as materiais relacionadas</legend>
      <SignSubjectSelect
          v-model="sign.subjects"
      />
      <br />

      <AppButton type="submit">Atualizar sinal</AppButton>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import SignService from '~/services/SignService';
import { type SignType } from '~/types/Sign';
import LoadingService from "~/services/LoadingService";

export default defineComponent({
  name: 'updateSignPage',

  async setup() {
    definePageMeta({
      middleware: 'is-admin',
    });

    const { sign: id } = useRoute().params;

    const { data, status, refresh } = await useAsyncData(
        `fetchSignEdit-${id}`,
        () => SignService.find(Number(id), true),
        {
          default: () => ({
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
              keywords: [],
              subjects: [],
            }
          }),
        }
    );

    onBeforeMount(() => {
      LoadingService.show();
      setTimeout(() => {
        LoadingService.loaded(status.value, refresh);
      }, 300);
    });

    watch(status, ($new) => {
      LoadingService.loaded($new, refresh);
    });

    return {
      sign: computed(() => data.value.sign),
      id,
    }
  },

  methods: {
    async submit() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Atualizando sinal...',
        });
        this.$swal.showLoading();
        const sign: SignType = {...this.sign};
        if(sign.example?.description === '' || sign.example?.display === '') {
          delete sign.example;
        }
        if(sign.description?.text === '' || sign.description?.display === '') {
          delete sign.description;
        }
        await SignService.update(sign, Number(this.id));
        await this.$swal.fire({
          icon: 'success',
          title: 'Sinal atualizado com sucesso',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo('/');
      } catch (e) {
        this.$swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
      }
    }
  }
});
</script>