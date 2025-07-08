<template>
  <pre>{{ keyword }}</pre>
  <button @click="showUpdateKeyword = !showUpdateKeyword">Atualizar palavra-chave</button>
  <form v-if="showUpdateKeyword">
    <AppInput type="text" v-model="newKeyword.name" name="new-keyword.name" />
    <button type="submit">Atualizar</button>
  </form>
</template>

<script lang="ts">
import KeywordService from '~/services/KeywordService';
import { type KeywordType } from '~/types/Keyword';
import LoadingService from '~/services/LoadingService';

export default defineComponent({
  name: 'keywordPage',

  async setup() {
    definePageMeta({
      middleware: 'is-admin',
    });
    const { keyword: id } = useRoute().params;

    const { data, status, execute, refresh } = useAsyncData(
      'fetchKeyword',
      () => KeywordService.find(Number(id)),
      {
        default: () => ({
          keyword: {
            name: '',
          },
        }),
        lazy: true,
        immediate: false,
      },
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
      keyword: computed(() => data.value.keyword),
      id: Number(id),
      refresh,
    };
  },

  data() {
    const newKeyword: KeywordType = {
      name: this.keyword?.name,
    };
    return {
      showUpdateKeyword: false,
      newKeyword,
    };
  },

  methods: {
    async submit() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Atualizando palavra-chave...',
        });
        this.$swal.showLoading();
        await KeywordService.update(this.newKeyword, this.id);
        await this.refresh();
        this.showUpdateKeyword = false;
        this.newKeyword.name = this.keyword.name;
        this.$swal.fire({
          title: 'Palavra-chave atualizada com sucesso!',
          icon: 'success',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
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
    },
  },
});
</script>
