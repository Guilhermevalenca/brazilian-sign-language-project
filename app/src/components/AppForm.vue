<script lang="ts">
export default defineComponent({
  name: "AppForm"
})
</script>

<template>
<form v-bind="$attrs">
  <slot/>
</form>
</template>

<style scoped>
form{
  display: flex;
  flex-direction: column;
  align-items: stretch;
  flex-wrap: nowrap;
  gap: 1em;
}
</style>