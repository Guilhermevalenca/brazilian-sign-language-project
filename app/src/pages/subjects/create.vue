<template>
  <AppCard>
    <div>
      <h1>Adicionar Materia</h1>
    </div>
    <AppForm>
      <div>
        <label>
          Nome:
          <AppInput type="text" placeholder="Digite o nome da matéria"/>
        </label>
      </div>
      <div>
        <label>
          Selecionar cursos:

        </label>
      </div>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
  name: "create",
  data(){
    return{
      subjects:[]
    }
  }
})
</script>

<style scoped lang="scss">

</style>