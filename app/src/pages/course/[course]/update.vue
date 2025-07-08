<template>
  <AppCard>
    <h1>Atualizar informações do curso</h1>
    <AppForm @submit.prevent="submit" enctype="multipart/form-data">
      <label>
        Nome do curso:
        <AppInput placeholder="Digite o nome do curso" v-model="course.name" name="course.name" />
      </label>
      <label>
        Escolha uma imagem:
        <AppInput
          type="file"
          placeholder="Escolha uma imagem"
          accept="image/*"
          @input="course.image = $event.target.files[0]"
          name="course.image"
        />
      </label>
      <legend>Palavras-chave</legend>
      <KeywordSelect v-model="course.keywords" />
      <AppButton type="submit">Atualizar Curso</AppButton>
    </AppForm>
  </AppCard>
</template>

<script setup lang="ts">
import type { CourseType } from '~/types/Course';
import CourseService from '~/services/CourseService';
import LoadingService from '~/services/LoadingService';

const { course: id } = useRoute().params;
const { data, refresh, status } = await useAsyncData(
  `fetchCourseEdit-${id}`,
  () => CourseService.edit(Number(id)),
  {
    default: () => ({
      course: {
        id: Number(id),
        name: '',
        image: '',
        keywords: [],
      } as CourseType,
    }),
  },
);
const course = computed(() => data.value.course);

onBeforeMount(() => {
  LoadingService.show();
  setTimeout(() => {
    LoadingService.loaded(status.value, refresh);
  }, 300);
});

watch(status, ($new) => {
  LoadingService.loaded($new, refresh);
});

async function submit() {
  const { $swal } = useNuxtApp();
  try {
    $swal.fire({
      icon: 'info',
      title: 'Atualizando curso...',
    });
    $swal.showLoading();
    await CourseService.update(
      {
        ...course.value,
      },
      Number(id),
    );
    await $swal.fire({
      icon: 'success',
      title: 'Curso atualizado com sucesso',
      timer: 10000,
      showConfirmButton: true,
      confirmButtonText: 'OK',
    });
    navigateTo('/');
  } catch (error) {
    console.log(error);
    $swal.fire({
      icon: 'error',
      title: 'Algo deu errado',
      text: 'Ocorreu um erro, gostaria de tentar novamente ?',
      timer: 10000,
      showConfirmButton: true,
      confirmButtonText: 'OK',
    });
  }
}
</script>

<style scoped lang="scss"></style>
