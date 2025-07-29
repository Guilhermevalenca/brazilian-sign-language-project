<template>
  <div class="content-title">
    <h1>Cursos</h1>
  </div>
  <div>
    <div class="course-card-container">
      <CourseCard
          v-for="course in courses"
          :key="`course.id-${course.id}`"
          :course="course"
          @click="navigateTo(`/course/${course.id}`)"
      />
    </div>
    <Pagination v-model:page="page" :last-page="data.last_page" />
  </div>
</template>

<script setup lang="ts">
import CourseService from '~/services/CourseService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { CourseType } from '~/types/Course';
import LoadingService from '~/services/LoadingService';

const { $swal } = useNuxtApp();
const page = ref(1);

const { status, data, refresh } = await useAsyncData<{
  courses: CourseType[];
  last_page: number;
}>('fetch-courses', () => CourseService.fetch(page.value), {
  default: () => ({
    courses: [],
    last_page: 1,
  }),
});
const courses = computed(() => data.value?.courses ?? []);

watch(status, ($new) => {
  LoadingService.loaded($new, refresh, true);
});

watch(page, async () => {
  if (page.value <= 0) {
    page.value = 1;
  }
  if (page.value > data.value.last_page) {
    page.value = data.value.last_page;
  }
  $swal.fire({
    icon: 'info',
    title: 'Carregando cursos',
  });
  $swal.showLoading();
  await refresh();
  $swal.close();
});

onBeforeMount(() => {
  LoadingService.show();
  setTimeout(() => {
    LoadingService.loaded(status.value, refresh, true);
  }, 300);
});

onMounted(() => {
  useBreadcrumbStore().home();
});
</script>
<style scoped lang="scss">
  .course-card-container {
    display: grid;
    max-width: 100%;
    grid-template-columns: repeat(auto-fit, minmax(160px, auto));
    justify-items: center;
    gap: 1em;
    padding:0;
    margin: 0;
    @media (max-width: 576px) {
      grid-template-columns: repeat(auto-fill, minmax(320px,1fr));
    }
  }
  .content-title{
    display: grid;
    align-self: center;
    justify-self: center;
  }

</style>
