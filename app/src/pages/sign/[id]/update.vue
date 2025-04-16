<template>
  <div>atualizar sinal</div>
  <form @submit.prevent="submit">
    <div>
      <p>informações do sinal</p>
      <AppInput
          v-model="sign.name"
          placeholder="Nome do sinal"
          name="sign.name"
      />
      <br />
      <AppInput
          v-model="sign.display"
          placeholder="Link do video"
          name="sign.display"
      />
      <small>Apenas links do youtube</small>
    </div>
    <div>
      <p>descrição do sinal <span class="tw-text-xs">* Campos não obrigatorios</span></p>
      <textarea
          v-model="sign.description!.text"
          placeholder="Descrição do sinal"
          name="sign.description.text"
      />
      <br />
      <AppInput
          v-model="sign.description!.display"
          placeholder="Video descrevendo o sinal"
          name="sign.description.display"
      />
      <small>Apenas links do youtube</small>
    </div>
    <div>
      <p>Exemplo de uso do sinal <span class="tw-text-xs">* Campos não obrigatorios</span></p>
      <AppInput
          v-model="sign.example!.description"
          placeholder="descrição do exemplo"
          name="sign.example.description"
      />
      <br />
      <AppInput
          v-model="sign.example!.display"
          placeholder="link do exemplo"
          name="sign.example.display"
      />
      <small>Apenas links do youtube</small>
    </div>
    <button type="submit">Atualizar sinal</button>
  </form>
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

    const { id } = useRoute().params;

    const { data, status, execute, refresh } = useAsyncData(
        'fetchSign',
        () => SignService.find(Number(id)),
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
              }
            }
          })
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

    execute();

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
        navigateTo(-1);
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