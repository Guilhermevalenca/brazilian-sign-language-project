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
  flex-direction: column;
  justify-items: flex-start;
  align-items: flex-start;
  flex-wrap: nowrap;
  gap: 1em;
}
</style>