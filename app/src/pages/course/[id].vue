<template>
  <div class="content-container-list">
    <div class="content-title">
      <h1>Disciplinas de: {{ course.name }}</h1>
    </div>
    <AppCard
        v-for="subject in course.subjects"
        tabindex="1"
        variant="list"
        role="button"
        :key="subject.id"
        @click="$router.push(`/subject/${subject.id}`)"
    >
      <ul>{{ subject.name }}</ul>
    </AppCard>
  </div>
  <Pagination v-model:page="page" :lastPage="last_page" />
</template>

<script lang="ts">
import CourseService from '~/services/CourseService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { CourseType } from '~/types/Course';
import LoadingService from "~/services/LoadingService";

export default defineComponent({
  name: 'coursePage',

  async setup() {
    const { id } = useRoute().params;
    const page = ref(1);

    const { data, status, execute, refresh } = useAsyncData(
        'fetchSubject',
        () => CourseService.find(Number(id), page.value),
        {
          default: () => ({
            course: {
              name: '',
              image: '',
              subjects: [],
            } as CourseType,
            last_page: 1
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

    execute();

    return {
      course: computed((): CourseType => data.value.course),
      page,
      last_page: computed(() => data.value.last_page),
      refresh,
      id
    }
  },

  watch: {
    async page() {
      if(this.page <= 0) {
        this.page = 1;
      }
      if(this.page > this.last_page) {
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
    "course.name": {
      handler($new) {
        useBreadcrumbStore().activeCourse($new ?? '', '/course/' + this.id);
      },
      deep: true,
      immediate: true,
    }
  },
})
</script>