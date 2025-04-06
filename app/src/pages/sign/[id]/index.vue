<template>
  <button @click="$router.push(`/sign/${sign?.id}/update`)">Atualizar</button>
  <br />
  <button @click="destroy">deletar ou apagar</button>
  <span class="tw-text-xs">*Esta opção apagará o contéudo para sempre</span>
  <br />
  <iframe
      :src="sign?.display"
      frameborder="0"
      allowfullscreen
  >
  </iframe>
  <!-- apenas para listar as informações do objeto -->
  <p>informações:</p>
  <div>
    <fieldset>
      <legend>Sinal</legend>
      <ul>{{ sign?.name }}</ul>
      <ul>{{ sign?.display }}</ul>
    </fieldset>
    <fieldset>
      <legend>Descrição</legend>
      <ul>{{ sign?.description?.text }}</ul>
      <ul>{{ sign?.description?.display }}</ul>
    </fieldset>
    <fieldset>
      <legend>Exemplo</legend>
      <ul>{{ sign?.example?.description }}</ul>
      <ul>{{ sign?.example?.display }}</ul>
    </fieldset>
  </div>
</template>

<script lang="ts">

import SignService from '~/services/SignService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { SignType } from '~/types/Sign';
import SubjectService from "~/services/SubjectService";
import LoadingService from "~/services/LoadingService";

export default defineComponent({
  name: 'signPage',

  async setup() {
    const { id } = useRoute().params;

    const { data, status, execute, refresh } = useAsyncData(
        'fetchSubject',
        () => SignService.find(Number(id)),
        {
          default: () => ({
            sign: {
              name: '',
              display: '',
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

    try {
      execute();
    } catch (e) {
      console.log(e);
    }

    return {
      sign: computed((): SignType => data.value.sign as SignType),
      id
    }
  },

  methods: {
    async destroy() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Deletando sinal...',
        });
        this.$swal.showLoading();
        await SignService.delete(Number(this.id));
        await this.$swal.fire({
          icon: 'success',
          title: 'Sinal deletado com sucesso',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        this.$router.go(-1);
      } catch(e) {
        console.log(e);
      }
    }
  },

  watch: {
    "sign.name": {
      handler($new) {
        useBreadcrumbStore().activeSign($new ?? '', '/sign/' + this.id);
      },
      deep: true,
      immediate: true,
    }
  }
});
</script>