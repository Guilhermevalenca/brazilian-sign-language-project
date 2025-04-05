<template>
  <div>
    <button @click="showAddKeyword = !showAddKeyword">Adicionar palavra-chave</button>
    <form v-if="showAddKeyword" @submit.prevent="submit">
      <AppInput
          type="text"
          v-model="newKeyword.name"
          placeholder="nome da nova palavra-chave"
          name="new-keyword.name"
      />
      <br />
      <button>Adicionar</button>
    </form>
  </div>
  <br />
  <div>
    <fieldset>
      <legend>Buscar palavra-chave</legend>
      <AppInput
          type="text"
          v-model="keywordSearch"
          placeholder="palavra-chave"
          name="keyword-search"
      />
    </fieldset>
  </div>
  <br />
  <p>Palavras-chave</p>
  <div v-for="keyword in keywordsFiltered" :key="keyword.id">
    <fieldset>
      <pre>{{ keyword }}</pre>
      <NuxtLink :to="`/keyword/${keyword.id}`">Atualizar palavra-chave</NuxtLink>
    </fieldset>
  </div>
  <AppButton @click="() => {page++; refresh()}" :disabled="page === last_page">Carregar mais palavras-chave</AppButton>
</template>

<script lang="ts">
import type { KeywordType } from '~/types/Keyword';
import KeywordService from '~/services/KeywordService';
import LoadingService from "~/services/LoadingService";

export default defineComponent({
  name: 'keywordPage',

  async setup() {
    definePageMeta({
      middleware: 'is-admin',
    });

    const page = ref(1);

    const { data, status, execute, refresh } = useAsyncData(
        'fetchKeywords',
        () => KeywordService.fetch(page.value),
        {
          default: () => ({
            keywords: [],
            last_page: 1
          }),
        }
    );

    onBeforeMount(() => {
      LoadingService.show();
    });

    watch(status, ($new) => {
      LoadingService.loaded($new, refresh);
    });

    execute();

    return {
      keywords: computed(() => data.value.keywords),
      page,
      last_page: computed(() => data.value.last_page),
      refresh,
    }
  },

  data: () => ({
    keywordSearch: '',
    newKeyword: {
      name: '',
    } as KeywordType,
    showAddKeyword: false
  }),

  methods: {
    async submit() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Criando palavra-chave...',
        });
        this.$swal.showLoading();
        await KeywordService.create(this.newKeyword);
        this.page = 1;
        this.keywords = [];
        await this.refresh();
        this.showAddKeyword = false;
        this.newKeyword.name = '';
        this.$swal.fire({
          title: 'Palavra-chave criada com sucesso!',
          icon: 'success',
          confirmButtonText: 'OK',
          showConfirmButton: true,
        });
      } catch(e) {
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
  },

  computed: {
    keywordsFiltered(): KeywordType[] {
      return this.keywords.filter((keyword: KeywordType) => {
        if(keyword.name) {
          return keyword.name.toLowerCase().includes(this.keywordSearch.toLowerCase());
        } else {
          return false;
        }
      })
    }
  }
})
</script>