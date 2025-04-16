<template>
<AppCard>
  <div class="navigation">
    <AppButton type="button" @click="navigateTo('/')" variant="navigation">
      <img src="~/assets/icons/arrow-left.svg" width="24" height="24">
      Voltar
    </AppButton>
  </div>
  <h1>Adicionar Curso</h1>
  <AppForm @submit.prevent="submit" enctype="multipart/form-data">
    <label>
      Nome do curso:
      <AppInput 
        placeholder="Digite o nome do curso"
        v-model="course.name"
        name="course.name"
      />
    </label>
    <label>
      Escolha uma imagem:
      <AppInput
        type="file" 
        placeholder="Escolha uma imagem" 
        accept="image/*" 
        @change="course.image = $event.target.files[0]"
        name="course.image"
      />
    </label>
    <legend>Palavras-chave</legend>
    <KeywordSelect
      v-model="course.keywords"
    />
    <AppButton type="submit">Criar Curso</AppButton>
  </AppForm>
</AppCard>
</template>

<script lang="ts">
import { type CourseType } from '~/types/Course';
import CourseService from '~/services/CourseService';

export default{
  name: "create",

  data: () => ({
    course: {
      name: '',
      image: '',
      keywords: [],
    } as CourseType,
  }),

  methods: {
    async submit() {
      try {
        this.$swal.fire({
          title: 'Criando curso...',
        });
        this.$swal.showLoading();
        await CourseService.create(this.course, this.course.keywords?.map((k) => Number(k.id)) as number[]);
        await this.$swal.fire({
          icon: 'success',
          title: 'Curso criado com sucesso!',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo('/');
      } catch(e) {
        this.$swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'Tentar novamente',
        });
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .navigation{
    display: flex;
    flex-flow: row nowrap;
    justify-content: flex-start;
    width: 100%;
    box-sizing: border-box;
    AppButton{
      display: flex;
      align-content: center;
      flex: auto;
    }
  }
</style>