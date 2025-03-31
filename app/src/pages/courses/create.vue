<template>
<AppCard>
  <div class="navigation">
    <AppButton type="button" @click="$router.push('/')" variant="navigation">
      <img src="../../assets/icons/arrow-left.svg" width="24" height="24">
      Voltar
    </AppButton>
  </div>
  <h1>Adicionar Curso</h1>
  <AppForm>
    <label>
      Nome do curso:
      <AppInput placeholder="Digite o nome do curso"/>
    </label>
    <label>
      Escolha uma imagem:
      <AppInput type="file"/>
    </label>
      <AppButton type="submit">Criar Curso</AppButton>
  </AppForm>
</AppCard>
</template>

<script lang="ts">
export default{
  name: "create"
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

