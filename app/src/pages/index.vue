<template>
  <div class="content-container">
    <div class="content-title">
      <h1>Cursos</h1>
    </div>
    <div class="index-content">
      <CourseCard
          v-for="course in courses" :key="course.id"
          :course="course"
          @click="$router.push(`/course/${course.id}`)"
      />
    </div>
    <Pagination v-model:page="page" :last-page="last_page"/>
  </div>

</template>

<script lang="ts">
import CourseService from '~/services/CourseService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { CourseType } from '~/types/Course';

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
        }
    );

    const { $swal } = useNuxtApp();

    watch(status, ($new) => {
      $swal.fire({
        title: 'Carregando...',
        didOpen: () => {
          $swal.showLoading();
        },
        didClose: () => {
          $swal.hideLoading();
        }
      });
      if($new === 'success') {
        $swal.close();
      } else if($new === 'error') {
        $swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          confirmButtonText: 'Tente novamente',
          allowOutsideClick: false,
          allowEscapeKey: false,
        }).then((res) => {
          if(res.isConfirmed) {
            refresh();
          }
        });
      }
    }, {
      immediate: true,
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
    page() {
      if(this.page <= 0) {
        this.page = 1;
      }
      if(this.page > this.last_page) {
        this.page = this.last_page;
      }
      this.refresh();
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