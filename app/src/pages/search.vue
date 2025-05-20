<template>
    <div class="results-screen">
      <h2>Filtros</h2>

      <div class="filters-container">
        <label class="filter-item">
          <input type="checkbox" v-model="filterOptions.courses" class="accent-blue-500" />
          <span>Cursos</span>
        </label>
        <label class="filter-item">
          <input type="checkbox" v-model="filterOptions.subjects" class="accent-green-500" />
          <span>Matérias</span>
        </label>
        <label class="filter-item">
          <input type="checkbox" v-model="filterOptions.signs" class="accent-purple-500" />
          <span>Sinais</span>
        </label>
      </div>

        <h2>Resultados</h2>
        <div class="content-results-screen">
          <div class="results">
            <h3>Cursos</h3>
            <div v-if="courses && courses.length > 0">
              <AppCard variant="list"  v-for="(course , index) in courses " :key="course.id" @click="navigateTo(`/course/${course.id}`)"> {{ course.name }}</AppCard>
            </div>
            <EmptySection v-else/>
          </div>

          <div class="results">
            <h3>Matérias</h3>
            <div v-if="subjects && subjects.length > 0">
              <AppCard variant="list" v-for="(subject, index) in subjects" :key="subject.id" @click="navigateTo(`/subject/${subject.id}`)">{{ subject.name }}</AppCard>
            </div>
            <EmptySection v-else/>
          </div>

          <div class="results">
            <h3>Sinais</h3>
            <div v-if="signs && signs.length > 0">
              <AppCard variant="list" v-for="(sign, index) in signs" :key="sign.id" @click="navigateTo(`/sign/${sign.id}`)">{{ sign.name }}</AppCard>
            </div>
            <EmptySection v-else/>
          </div>
        </div>
      <client-only>
        <Pagination v-model:page="page" :lastPage="last_page" />
      </client-only>
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
.results-screen{
  display: flex;
  flex-flow: column wrap;
  gap: 1em;
}
.filters-container{
  display: flex;
  flex-flow: column wrap;
}
.content-results-screen{
  display: flex;
  flex-flow: column wrap;
  align-items: flex-start;
}
.results{
  display: flex;
  flex-flow: column wrap;
  gap: 0.5em;
}
</style>