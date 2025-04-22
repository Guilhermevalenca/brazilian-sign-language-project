<template>
  <div class="content-container">
    <div class="content-title">
      <h1>Cursos</h1>
    </div>
    <div class="index-content">
      <CourseCard
          v-for="course in courses" :key="course.id"
          :course="course"
          @click="navigateTo(`/course/${course.id}`)"
      />
    </div>
    <Pagination v-model:page="page" :last-page="last_page"/>
  </div>

</template>

<script lang="ts">
import CourseService from '~/services/CourseService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { CourseType } from '~/types/Course';
import LoadingService from "~/services/LoadingService";

export default defineComponent({
  name: 'homePage',

  async setup() {
    const page = ref(1);

    const { status, data, refresh, execute } = useAsyncData<{
      courses: CourseType[],
      last_page: number,
    }>(
        'fetchCourses',
        () => CourseService.fetch(page.value),
        {
          default: () => ({
            courses: [],
            last_page: 1
          }),
        },
    );

    onBeforeMount(() => {
      LoadingService.show();
      setTimeout(() => {
        LoadingService.loaded(status.value, refresh, true);
      }, 300);
    });

    watch(status, ($new) => {
      LoadingService.loaded($new, refresh, true);
    });

    execute();

    return {
      courses: computed(() => data.value?.courses ?? []),
      page,
      last_page: computed(() => data.value?.last_page ?? 1),
      status,
      refresh,
    };
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
        title: 'Carregando cursos',
      });
      this.$swal.showLoading();
      await this.refresh();
      this.$swal.close();
    },
  },

  mounted() {
    useBreadcrumbStore().home();
  }
});

</script>
<style lang="scss" scoped>
.index-content{
  display: flex;
  align-self: center;
  justify-self: center;
  align-items: stretch;
  align-content: stretch;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-around;
  gap: 4em;
  padding: 2em;
}
</style>