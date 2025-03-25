<template>
<AppCard>
  <AppForm>
    <h1>Adicionar Curso</h1>
    <label>
      Nome do curso:
      <AppInput placeholder="Digite o nome do curso"/>
    </label>
    <label>
      Escolha uma imagem:
      <AppInput type="file"/>
    </label>
    <FormActions>
      <AppButton type="button" @click="$router.push('/')" variant="deny">Cancelar</AppButton>
      <AppButton type="submit">Criar Curso</AppButton>
    </FormActions>
  </AppForm>
</AppCard>
</template>

<script lang="ts">
export default{
  name: "create"
}
</script>

