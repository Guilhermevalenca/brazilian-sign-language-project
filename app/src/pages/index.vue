<template>
  <div>
    <ExampleComponent />
  </div>
  <fieldset>
    <p>Sistema de busca:</p>
    <client-only>
      <AppSearch />
    </client-only>
  </fieldset>
</template>

<script lang="ts">
  
export default defineComponent({
  name: 'homePage',
});
  
</script>
<style>
*{
  margin:0;
  padding: 0;
}
</style>