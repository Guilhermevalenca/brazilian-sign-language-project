<template>
  <fieldset>
    <p>Filtros</p>
    <div class="tw-flex tw-gap-2">
      <div>
        <input type="checkbox" v-model="filterOptions.courses" />
        <label>Cursos</label>
      </div>
      <div>
        <input type="checkbox" v-model="filterOptions.subjects" />
        <label>Materias</label>
      </div>
      <div>
        <input type="checkbox" v-model="filterOptions.signs" />
        <label>Sinais</label>
      </div>
    </div>
  </fieldset>
  <client-only>
    <Pagination v-model:page="page" :lastPage="last_page" />
  </client-only>
  <fieldset>
    <p>Resultados:</p>
    <div class="tw-flex tw-gap-2">
      <div>
        <p>Cursos</p>
        <pre>{{ courses }}</pre>
      </div>
      <div>
        <p>Materias</p>
        <pre>{{ subjects }}</pre>
      </div>
      <div>
        <p>Sinais</p>
        <pre>{{ signs }}</pre>
      </div>
    </div>
  </fieldset>
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

    const { data, status, refresh } = useAsyncData(
        'fetchSubjects',
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

    watch(searchData, async () => {
      page.value = 1;
      await refresh();
    });

    return {
      courses: computed(() => data.value?.courses),
      subjects: computed(() => data.value?.subjects),
      signs: computed(() => data.value?.signs),
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