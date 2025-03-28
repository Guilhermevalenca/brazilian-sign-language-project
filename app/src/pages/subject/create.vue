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
            v-model="courses"
          />
        </label>
      </div>
      <AppButton type="submit">Adicionar Material</AppButton>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import Subject from '~/classes/Subject';

export default defineComponent({
  name: "create",
  data(){
    return{
      subject: new Subject({
        name: '',
      }),
      courses: [],
    }
  },

  methods: {
    async submit() {
      try {
        if(this.courses.length > 0) {
          this.subject.setCourses(this.courses);
        }
        await this.subject.register();
      } catch(error) {

      }
    }
  }
})
</script>

<style scoped lang="scss">

</style>