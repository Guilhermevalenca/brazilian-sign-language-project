<template>
    <div class="results-screen">
        <div class="content-results-screen">
          <h1>Resultados da pesquisa: "{{ searchData }}" </h1>
          <div v-show="!filterOptions.courses && !filterOptions.subjects && !filterOptions.signs || filterOptions.courses" class="results">
            <h2>Cursos</h2>
            <div class="results" v-if="courses && courses.length > 0">
              <AppCard variant="list"  v-for="(course , index) in courses " :key="course.id" @click="navigateTo(`/course/${course.id}`)"><p>{{ course.name }}</p></AppCard>
            </div>
            <EmptySection class="empty" v-else>
              <p>Nenhum resultado encontrado</p>
            </EmptySection>
          </div>

          <div  v-show="!filterOptions.courses && !filterOptions.subjects && !filterOptions.signs || filterOptions.subjects" class="results">
            <h2>Disciplinas</h2>
            <div class="results" v-if="subjects && subjects.length > 0">
              <AppCard variant="list" v-for="(subject, index) in subjects" :key="subject.id" @click="navigateTo(`/subject/${subject.id}`)"><p>{{ subject.name }}</p></AppCard>
            </div>
            <EmptySection class="empty" v-else>
              <p>Nenhum resultado encontrado</p>
            </EmptySection>
          </div>

          <div  v-show="!filterOptions.courses && !filterOptions.subjects && !filterOptions.signs || filterOptions.signs" class="results">
            <h2>Sinais</h2>
            <div class="results" v-if="signs && signs.length > 0">
              <AppCard variant="list" v-for="(sign, index) in signs" :key="sign.id" @click="navigateTo(`/sign/${sign.id}`)">{{ sign.name }}</AppCard>
            </div>
            <EmptySection class="empty" v-else>
              <p>Nenhum resultado encontrado</p>
            </EmptySection>
          </div>
        </div>
      <div class="filters-container">
        <h1>Filtros</h1>
        <label class="filter-item">
          <input type="checkbox" v-model="filterOptions.courses" class="accent-blue-500" />
          <span>Cursos</span>
        </label>
        <label class="filter-item">
          <input type="checkbox" v-model="filterOptions.subjects" class="accent-green-500" />
          <span>Disciplinas</span>
        </label>
        <label class="filter-item">
          <input type="checkbox" v-model="filterOptions.signs" class="accent-purple-500" />
          <span>Sinais</span>
        </label>
      </div>
    </div>
</template>

<script lang="ts">
import SystemSourceService, { type FilterOptionsType } from '~/services/SystemSourceService';
import LoadingService from "~/services/LoadingService";
import useBreadcrumbStore from "~/stores/useBreadcrumbStore";

export default defineComponent({
  name: 'searchPage',

  async setup() {
    const searchData = searchBarData();
    const filterOptions = ref<FilterOptionsType>({
      courses: false,
      subjects: false,
      signs: false
    });
    const page = ref(1);

    const { data, status, refresh, execute } = useAsyncData(
        `fetchSearch-${searchData?.value}`,
        () => SystemSourceService.searchActionWithFilter(
            String(searchData?.value),
            filterOptions.value,
            page.value
        ),
        {
          default: () => ({
            courses: [],
            subjects: [],
            signs: [],
            last_page: 1,
          }),
          immediate: false,
          lazy: true,
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

    watch(searchData, async () => {
      page.value = 1;
      await refresh();
    });

    execute();

    return {
      courses: computed(() => data.value?.courses ?? []),
      subjects: computed(() => data.value?.subjects ?? []),
      signs: computed(() => data.value?.signs ?? []),
      last_page: computed((): number => data.value?.last_page),
      searchData,
      filterOptions,
      refresh,
      page,
    }
  },

  watch: {
    filterOptions: {
      handler() {
        this.refresh();
      },
      deep: true,
    },
    async page() {
      if(this.page <= 0) {
        this.page = 1;
      }
      if(this.page > this.last_page) {
        this.page = this.last_page;
      }
      this.$swal.fire({
        icon: 'info',
        title: 'Carregando...',
      });
      this.$swal.showLoading();
      await this.refresh();
      this.$swal.close();
    }
  },

  mounted() {
    useBreadcrumbStore().activeSearch();
  }
})
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
.filter-item{
  display: flex;
  gap:0.6em;
}
.empty{
  display: flex;
  flex-flow: column;
  align-self: flex-start;
  margin-left: 0em;
}
</style>