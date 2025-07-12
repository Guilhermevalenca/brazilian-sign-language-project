<template>
  <div class="results-screen">
    <div class="content-results-screen">
      <h1>Resultados da pesquisa: "{{ searchData }}"</h1>

      <div class="results" v-if="signs && signs.length > 0">
        <h2>Sinais</h2>
        <AppCard
          variant="list"
          v-for="(sign, index) in signs"
          :key="sign.id"
          @click="navigateTo(`/sign/${sign.id}`)"
          >{{ sign.name }}</AppCard
        >
      </div>

      <div class="results" v-if="subjects && subjects.length > 0">
        <h2>Disciplinas</h2>
        <AppCard
          variant="list"
          v-for="(subject, index) in subjects"
          :key="subject.id"
          @click="navigateTo(`/subject/${subject.id}`)"
          ><p>{{ subject.name }}</p></AppCard
        >
      </div>

      <div class="results" v-if="courses && courses.length > 0">
        <h2>Cursos</h2>
        <AppCard
          variant="list"
          v-for="(course, index) in courses"
          :key="course.id"
          @click="navigateTo(`/course/${course.id}`)"
          ><p>{{ course.name }}</p></AppCard
        >
      </div>

      <EmptySection
        class="empty"
        v-if="subjects.length === 0 && courses.length === 0 && signs.length === 0"
      >
        <p>Nenhum resultado encontrado.</p>
      </EmptySection>
    </div>

    <div class="filters-container">
      <h1>Filtros</h1>
      <label class="filter-item">
        <input type="checkbox" v-model="filterOptions.signs" class="accent-purple-500" />
        <span>Sinais</span>
      </label>

      <label class="filter-item">
        <input type="checkbox" v-model="filterOptions.subjects" class="accent-green-500" />
        <span>Disciplinas</span>
      </label>

      <label class="filter-item">
        <input type="checkbox" v-model="filterOptions.courses" class="accent-blue-500" />
        <span>Cursos</span>
      </label>
    </div>
  </div>
</template>

<script setup lang="ts">
import SystemSourceService, { type FilterOptionsType } from '~/services/SystemSourceService';
import LoadingService from '~/services/LoadingService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';

const searchData = searchBarData();
const filterOptions = ref<FilterOptionsType>({
  courses: false,
  subjects: false,
  signs: false,
});
const page = ref(1);
const { $swal } = useNuxtApp();

const { data, status, refresh } = await useAsyncData(
  `fetchSearch-${searchData?.value}`,
  () =>
    SystemSourceService.searchActionWithFilter(
      String(searchData?.value),
      filterOptions.value,
      page.value,
    ),
  {
    default: () => ({
      courses: [],
      subjects: [],
      signs: [],
      last_page: 1,
    }),
    lazy: true,
  },
);
const courses = computed(() => data.value?.courses ?? []);
const subjects = computed(() => data.value?.subjects ?? []);
const signs = computed(() => data.value?.signs ?? []);
const last_page = computed(() => data.value?.last_page ?? 1);

let debounce: number | null = null;
watch(searchData, async () => {
  if (debounce) {
    clearTimeout(debounce);
  }
  debounce = setTimeout(async () => {
    $swal.fire({
      icon: 'info',
      title: 'Carregando...',
    });
    $swal.showLoading();
    page.value = 1;
    await refresh();
    $swal.close();
  }, 700);
});

watch(
  filterOptions,
  async () => {
    page.value = 1;
    await refresh();
  },
  {
    deep: true,
  },
);

watch(page, async () => {
  if (page.value <= 0) {
    page.value = 1;
  }
  if (page.value > last_page.value) {
    page.value = last_page.value;
  }
  $swal.fire({
    icon: 'info',
    title: 'Carregando...',
  });
  $swal.showLoading();
  await refresh();
  $swal.close();
});

watch(status, ($new) => {
  LoadingService.loaded($new, refresh);
});

onBeforeMount(() => {
  LoadingService.show();
  setTimeout(() => {
    LoadingService.loaded(status.value, refresh);
  }, 300);
});

onMounted(() => {
  useBreadcrumbStore().activeSearch();
});

onUnmounted(() => {
  searchData.value = '';
});
</script>

<style lang="scss" scoped>
.results-screen {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 1em;
  align-items: start;
  margin-bottom: 10em;
}

.filters-container {
  margin-left: auto;
  display: flex;
  flex-direction: column;
  gap: 0.5em;
}

.content-results-screen {
  display: flex;
  flex-direction: column;
  gap: 1em;
  max-width: 45vw;
}

.results {
  display: flex;
  flex-direction: column;
  gap: 0.5em;
}
.filter-item {
  display: flex;
  gap: 0.6em;
}
.empty {
  display: flex;
  flex-flow: column;
  align-self: flex-start;
  margin-left: 0em;
}
</style>
