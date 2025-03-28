<template>
<AppCard>
  <AppForm @submit.prevent="submit" enctype="multipart/form-data">
    <h1>Adicionar Curso</h1>
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
    <FormActions>
      <AppButton type="button" @click="$router.push('/')" variant="deny">Cancelar</AppButton>
      <AppButton type="submit">Criar Curso</AppButton>
    </FormActions>
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

