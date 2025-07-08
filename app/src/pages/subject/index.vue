<template>
  <Pagination v-model:page="page" :lastPage="last_page" />
  <div v-for="subject in subjects" :key="subject.id">
    {{ subject.name }}
  </div>
  <Pagination v-model:page="page" :lastPage="last_page" />
</template>

<script lang="ts">
import SubjectService from '~/services/SubjectService';
import LoadingService from '~/services/LoadingService';

export default defineComponent({
  name: 'subjectPage',

  async setup() {
    const page = ref<number>(1);

    const { data, status, execute, refresh } = useAsyncData(
      'fetchSubjects',
      () => SubjectService.fetch(page.value),
      {
        default: () => ({
          subjects: [],
          last_page: 1,
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

    watch(
      status,
      ($new) => {
        LoadingService.loaded($new, refresh);
      },
      {
        immediate: true,
        deep: true,
      },
    );

    execute();

    return {
      subjects: computed(() => data.value.subjects),
      page,
      last_page: computed(() => data.value.last_page),
      refresh,
    };
  },

  watch: {
    async page($new) {
      if ($new <= 0) {
        this.page = 1;
      }
      if ($new > this.last_page) {
        this.page = this.last_page;
      }
      this.$swal.fire({
        icon: 'info',
        title: 'Carregando matérias',
      });
      this.$swal.showLoading();
      await this.refresh();
      this.$swal.close();
    },
  },
});
</script>
