<template>
    <AppInput type="text" v-model="keywordSearch" />
  <legend>Selecione as categorias:</legend>
  <div class="keywords-list-container">
    <div class="keywords-list-items" v-for="keyword in keywordsFiltered" :key="keyword.id">
      <input
          type="checkbox"
          :id="`keyword-${keyword.id}`"
          :value="keyword.name"
          v-model="keywordSearch"
      />
      <label :for="`keyword-${keyword.id}`">{{ keyword.name }}</label>
    </div>
  </div>
    <div role="button" @click="isAddKeyword = !isAddKeyword" class="acordion-container">
      <div class="acordion-title">
        Adicionar palavra-chave
        <img src="../../assets/icons/arrow-down.svg" width="16px" height="16px" :class="{rotate: isAddKeyword}">
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
import Keyword from '~/classes/Keyword';
import KeywordService from '~/services/KeywordService';

export default defineComponent({
    name: 'KeywordSelect',

    async setup() {
        const keywords = ref<Keyword[]>(await KeywordService.fetch());

        return {
            keywords,
        }
    },

    data: () => ({
        keywordSearch: '',
        newKeyword: new Keyword({
            name: '',
        }),
        isAddKeyword: false,
    }),

    props: {
        modelValue: {
            type: Array as PropType<Keyword[]>,
            required: true
        }
    },

    emits: ['update:modelValue'],

    computed: {
        selected: {
            get(): Keyword[] {
                return this.modelValue;
            },
            set(value: Keyword[]) {
                this.$emit('update:modelValue', value);
            }
        },
        keywordsFiltered(): Keyword[] {
            return this.keywords.filter((keyword) => {
                if(keyword.name) {
                    return keyword.name.toLowerCase().includes(this.keywordSearch.toLowerCase());
                } else {
                    return false;
                }
            })
        }
    },

    methods: {
        async submit() {
            try {
                await this.newKeyword.register();
                this.keywords = await KeywordService.fetch();
                this.isAddKeyword = false;
                this.newKeyword.name = '';
            } catch(e) {
                alert('deu errado!');
            }
        }
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