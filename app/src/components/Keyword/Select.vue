<template>
  <client-only v-if="keywords.length > 0">
    <AppSelect
      v-model="selected"
      :items="keywords"
      labelInput="name"
      placeholder="Pesquise pela palavra-chave"
      id="keyword"
    />
  </client-only>
  <div v-show="keywords.length === 0">
    <span>Nenhuma palavra-chave encontrada</span>
  </div>
  <div role="button" @click="isAddKeyword = !isAddKeyword" class="acordion-container">
    <div class="acordion-title">
      Adicionar palavra-chave
      <img
        src="~/assets/icons/arrow-down.svg"
        width="16px"
        height="16px"
        :class="{ rotate: isAddKeyword }"
      />
    </div>
    <transition name="slide">
      <div v-if="isAddKeyword" class="acordion-content" @click.stop>
        <!-- 🔹 Adicionando @click.stop -->
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

<script setup lang="ts">
import type { PropType } from 'vue';
import type { KeywordType } from '~/types/Keyword';
import KeywordService from '~/services/KeywordService';

const { $swal } = useNuxtApp();

const props = defineProps({
  modelValue: {
    type: Array as PropType<KeywordType[]>,
    required: true,
  },
});
const emit = defineEmits(['update:modelValue']);

const selected = computed({
  get(): KeywordType[] {
    return props.modelValue;
  },
  set(value: KeywordType[]) {
    emit('update:modelValue', value);
  },
});

const keywords = ref<KeywordType[]>([]);
const page = ref(1);
const last_page = ref(1);
const newKeyword = ref<KeywordType>({
  name: ''
});
const isAddKeyword = ref(false);

await getKeywords();

onMounted(async () => {
  setTimeout(() => {
    page.value = 2;
    getAllKeywords();
  }, 300);
});

async function getKeywords() {
  const data = await KeywordService.fetch(page.value);
  keywords.value = [...keywords.value, ...data.keywords];
  last_page.value = data.last_page;
}

async function submit() {
  try {
    $swal.fire({
      title: 'Criando palavra-chave...',
    });
    $swal.showLoading();

    await KeywordService.create(newKeyword.value);

    page.value = 1;
    keywords.value = [];
    await getAllKeywords();
    isAddKeyword.value = false;
    newKeyword.value.name = '';

    $swal.fire({
      title: 'Palavra-chave criada com sucesso!',
      icon: 'success',
    });
  } catch (e) {
    $swal
        .fire({
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
          if (res.isConfirmed) {
            submit();
          }
        });
  }
}

async function getAllKeywords() {
  if (page.value <= last_page.value) {
    await getKeywords();
    page.value++;
    setTimeout(() => {
      getAllKeywords();
    }, 100);
  }
}
</script>

<style lang="scss" scoped>
.keywords-list-container {
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  height: 10rem;
}
.keywords-list-items {
  display: flex;
  flex-direction: row;
  gap: 1rem;
}
.acordion-container {
  display: flex;
  flex-direction: column;
  padding: 1rem;
  gap: 1rem;
  border: solid 1px $primary-color;
  border-radius: 1rem;
  .acordion-title {
    display: flex;
    flex-direction: row;
    align-content: center;
    align-items: center;
    justify-content: space-between;
  }
}
.rotate {
  transform: rotate(180deg);
  transition: transform 0.3s ease-in-out;
}
.slide-enter-active,
.slide-leave-active {
  transition:
    max-height 0.5s ease-in-out,
    opacity 0.3s ease-in-out;
  overflow: hidden;
}

.slide-enter-from,
.slide-leave-to {
  max-height: 0;
  opacity: 0;
}

.acordion-content {
  max-height: 500px; /* Ajuste conforme necessário */
  overflow: hidden;
  transition:
    max-height 0.5s ease-in-out,
    opacity 0.3s ease-in-out;
}
</style>
