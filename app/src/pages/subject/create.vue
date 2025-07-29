<template>
  <AppCard>
    <div>
      <h1>Adicionar Materia</h1>
    </div>
    <AppForm @submit.prevent="submit">
      <div>
        <label>
          Nome:
          <AppInput
            type="text"
            placeholder="Digite o nome da matéria"
            name="subject.name"
            v-model="subject.name"
            maxlength="250"
          />
        </label>
      </div>
      <div>
        <legend>Selecionar cursos:</legend>
        <SubjectCourseSelect v-model="subject.courses" />
      </div>

      <legend>Palavras-chave</legend>
      <KeywordSelect v-model="subject.keywords" />
      <AppButton type="submit">Adicionar Materia</AppButton>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import SubjectService from '~/services/SubjectService';
import type { SubjectType } from '~/types/Subject';

export default defineComponent({
  name: 'create',

  data: () => ({
    subject: {
      name: '',
      courses: [],
      keywords: [],
    } as SubjectType,
  }),

  methods: {
    async submit() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Criando materia...',
        });
        this.$swal.showLoading();
        await SubjectService.create(
          this.subject,
          this.subject.courses ?? [],
          this.subject.keywords ?? [],
        );
        await this.$swal.fire({
          icon: 'success',
          title: 'Materia criada com sucesso',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo('/');
      } catch (error) {
        this.$swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
      }
    },
  },
});
</script>

<style scoped lang="scss"></style>
