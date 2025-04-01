<template>
<AppCard>
  <div class="navigation">
    <AppButton type="button" @click="$router.push('/')" variant="navigation">
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
      />
    </label>
    <label>
      Escolha uma imagem:
      <AppInput
        type="file" 
        placeholder="Escolha uma imagem" 
        accept="image/*" 
        @change="course.image = $event.target.files[0]"
      />
    </label>
    <AppButton type="submit">Criar Curso</AppButton>
  </AppForm>
</AppCard>
</template>

<script lang="ts">
import Course from '~/classes/Course';
import CourseService from '~/services/CourseService';

export default{
  name: "create",

  data: () => ({
    course: new Course({
      name: '',
      image: '',
    })
  }),

  methods: {
    async submit() {
      console.log(this.course);
      try {
        await CourseService.create(this.course);
        this.$router.push('/');
      } catch(e) {
        alert('deu errado!');
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