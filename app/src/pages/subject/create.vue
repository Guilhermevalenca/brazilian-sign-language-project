<template>
  <AppCard>
    <div>
      <h1>Adicionar Materia</h1>
    </div>
    <AppForm>
      <div>
        <label>
          Nome:
          <AppInput 
            type="text" 
            placeholder="Digite o nome da matéria"
            v-model="subject.name"  
          />
        </label>
      </div>
      <div>
        <label>
          Selecionar cursos:
          <SubjectCourseSelect 
            v-model="subject.courses"
          />
        </label>
      </div>

      <legend>Palavras-chave</legend>
      <KeywordSelect
          v-model="subject.keywords"
      />

      <AppButton type="submit">Adicionar Material</AppButton>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import SubjectService from '~/services/SubjectService';
import type { SubjectType } from '~/types/Subject';

export default defineComponent({
  name: "create",
  data(){
    return{
      subject: {
        name: '',
        courses: [],
        keywords: [],
      } as SubjectType,
    }
  },

  methods: {
    async submit() {
      try {
        await SubjectService.create(this.subject, this.subject.keywords?.map((k) => Number(k.id)) as number[]);
        this.$router.go(-1);
      } catch(error) {

      }
    }
  }
})
</script>

<style scoped lang="scss">

</style>