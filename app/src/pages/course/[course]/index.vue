<template>
  <div class="update-container" v-if="userStore.is_admin">
    <AppButton @click="() => navigateTo('/course/' + id + '/update')">
      <img src="~/assets/icons/edit.svg" width="24px" height="24px" alt="Editar curso">
      Editar curso
    </AppButton>
    <AppButton @click="deleteCourse">
      <img src="~/assets/icons/delete.svg" width="24px" height="24px" alt="Excluir curso">
      Excluir curso
    </AppButton>
  </div>
  <div class="content-title">
    <h1>Disciplinas em {{ course?.name }}</h1>
  </div>
  <div v-if="course?.subjects && course?.subjects.length > 0" class="content-container-list">
    <AppCard
      class="subject"
      v-for="subject in course?.subjects ?? []"
      :key="subject.id"
      tabindex="1"
      variant="list"
      role="button"
      @click="navigateTo(`/subject/${subject.id}`)"
    >
      <ul>
        {{
          subject.name
        }}
      </ul>
    </AppCard>
  </div>
  <EmptySection v-else>
    <p>Nenhuma disciplina encontrada em {{ course.name }}.</p>
  </EmptySection>
  <Pagination v-model:page="page" :lastPage="last_page" />
</template>

<script lang="ts">
import CourseService from '~/services/CourseService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { CourseType } from '~/types/Course';
import LoadingService from '~/services/LoadingService';
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
  name: 'coursePage',

  async setup() {
    const { course: id } = useRoute().params;
    const page = ref(1);

    const { data, status, refresh } = useAsyncData(
      'fetch-course-show',
      () => CourseService.find(Number(id), page.value),
      {
        default: () => ({
          course: {
            name: '',
            image: '',
            subjects: [],
          } as CourseType,
          last_page: 1,
        }),
        lazy: true,
      },
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

    return {
      course: computed((): CourseType => data.value.course),
      page,
      last_page: computed(() => data.value.last_page),
      refresh,
      id,
      userStore: useUserStore(),
    };
  },

  watch: {
    async page() {
      if (this.page <= 0) {
        this.page = 1;
      }
      if (this.page > this.last_page) {
        this.page = this.last_page;
      }
      this.$swal.fire({
        title: 'Carregando matérias',
      });
      this.$swal.showLoading();
      await this.refresh();
      this.$swal.close();
    },
    'course.name': {
      handler($new) {
        useBreadcrumbStore().activeCourse($new ?? '', '/course/' + this.id);
      },
      deep: true,
      immediate: true,
    },
  },

  methods: {
    async deleteCourse() {
      const { $swal } = useNuxtApp();
      try {
        $swal.fire({
          title: 'Deletando curso...',
        });
        $swal.showLoading();
        await CourseService.delete(Number(this.id));
        await $swal.fire({
          icon: 'success',
          title: 'Curso deletado com sucesso',
          timer: 5000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo('/');
      } catch (e) {
        await $swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 3000,
          showConfirmButton: true,
          confirmButtonText: 'Tentar novamente',
        });
      }
    },
  },
});
</script>
<style lang="scss" scoped>
.subject:hover {
  background-color: #a6e4af;
  transform: scale(1.1, 1.1);
}
</style>
