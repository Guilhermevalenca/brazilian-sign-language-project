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
      <AppButton type="submit">Adicionar Material</AppButton>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import SubjectService from '~/services/SubjectService';
import { type SubjectType } from '~/types/Subject';

export default defineComponent({
  name: "create",
  data(){
    return{
      subject: {
        name: '',
        courses: [],
      } as SubjectType,
    }
  },

  methods: {
    async submit() {
      try {
        await SubjectService.create(this.subject);
      } catch(error) {

      }
    }
  }
})
</script>

<style scoped lang="scss">

</style>