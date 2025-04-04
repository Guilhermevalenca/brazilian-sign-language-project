<template>
  <AppInput type="text" v-model="keywordSearch" placeholder="Pesquise pela palavra-chave" />
  <legend>Selecione as categorias:</legend>
  <div class="keywords-list-container">
    <div class="keywords-list-items" v-for="(keyword, index) in keywordsFiltered" :key="keyword.id">
      <input
          type="checkbox"
          :id="`keyword-${keyword.id}`"
          @input="$event.target?.checked ? selected[index] = keyword : selected.splice(index, 1)"
      />
      <label :for="`keyword-${keyword.id}`">{{ keyword.name }}</label>
    </div>
  </div>
    <div role="button" @click="isAddKeyword = !isAddKeyword" class="acordion-container">
      <div class="acordion-title">
        Adicionar palavra-chave
        <img src="~/assets/icons/arrow-down.svg" width="16px" height="16px" :class="{rotate: isAddKeyword}">
      </div>
      <transition name="slide">
        <div v-if="isAddKeyword" class="acordion-content" @click.stop> <!-- 🔹 Adicionando @click.stop -->
          <AppForm @submit.prevent="submit">
            <label>
              <AppInput placeholder="Adicionar palavra-chave" v-model="newKeyword.name" />
            </label>
            <AppButton variant="navigation" type="submit">Adicionar</AppButton>
          </AppForm>
        </div>
      </transition>
    </div>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import type {KeywordType} from '~/types/Keyword';
import KeywordService from '~/services/KeywordService';

export default defineComponent({
    name: 'KeywordSelect',

    async setup() {
        const keywords = ref<KeywordType[]>([]);
        const page = ref(1);
        const last_page = ref(1);

        async function getKeywords() {
            const data = await KeywordService.fetch(page.value);
            keywords.value.push(...data.keywords);
            last_page.value = data.last_page;
        }

        getKeywords();

        return {
            keywords,
            page,
            last_page,
            getKeywords,
        }
    },

    data: () => ({
        keywordSearch: '',
        newKeyword: {
            name: '',
        } as KeywordType,
        isAddKeyword: false,
        selected: [] as KeywordType[]
    }),

    props: {
        modelValue: {
            type: Array as PropType<KeywordType[]>,
            required: true
        }
    },

    emits: ['update:modelValue'],

    computed: {
        keywordsFiltered(): KeywordType[] {
            return this.keywords.filter((keyword) => {
                if(keyword.name) {
                    return keyword.name.toLowerCase().includes(this.keywordSearch.toLowerCase());
                } else {
                    return false;
                }
            })
        }
    },

    watch: {
      selected($new) {
        this.$emit('update:modelValue', $new);
      }
    },

    methods: {
        async submit() {
            try {
                this.$swal.fire({
                  title: 'Criando palavra-chave...',
                });
                this.$swal.showLoading();

                await KeywordService.create(this.newKeyword);
                this.page = 1;
                this.keywords = [];
                await this.getAllKeywords();
                this.isAddKeyword = false;
                this.newKeyword.name = '';

                this.$swal.fire({
                  title: 'Palavra-chave criada com sucesso!',
                  icon: 'success',
                });
            } catch(e) {
                this.$swal.fire({
                  icon: 'error',
                  title: 'Algo deu errado',
                  text: 'Ocorreu um erro, gostaria de tentar novamente ?',
                  timer: 10000,
                  showConfirmButton: true,
                  confirmButtonText: 'Tentar novamente',
                  showCancelButton: true,
                  cancelButtonText: 'Cancelar',
                })
                    .then((res) => {
                      if(res.isConfirmed) {
                        this.submit();
                      }
                    })
            }
        },
        async getAllKeywords() {
          if(this.page < this.last_page) {
            await this.getKeywords();
            this.page++;
            setTimeout(this.getAllKeywords, 300);
          } else {
            await this.getKeywords();
          }
        }
    },

    async mounted() {
      this.getAllKeywords();
    }
});
</script>
<style lang="scss" scoped>
.keywords-list-container{
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  height: 10rem;
}
.keywords-list-items{
  display: flex;
  flex-direction: row;
  gap:1rem;
}
.acordion-container{
  display: flex;
  flex-direction: column;
  padding: 1rem;
  gap: 1rem;
  border: solid 1px $primary-color;
  border-radius: 1rem;
  .acordion-title{
    display: flex;
    flex-direction: row;
    align-content: center;
    align-items: center;
    justify-content: space-between;
  }
}
.rotate{
  transform: rotate(180deg);
  transition: transform 0.3s ease-in-out;
}
.slide-enter-active, .slide-leave-active {
  transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out;
  overflow: hidden;
}

.slide-enter-from, .slide-leave-to {
  max-height: 0;
  opacity: 0;
}

.acordion-content {
  max-height: 500px; /* Ajuste conforme necessário */
  overflow: hidden;
  transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out;
}
</style>