<template>
<div>
  <slot/>
</div>
</template>

<script lang="ts">
export default {
  name: "FormActions"
}
</script>

<style scoped>
div{
  display:flex;
  margin-left: auto;
  margin-right: auto;
  margin-top: 1em;
  margin-bottom: 1em;
  gap:5em;
  align-items: center;
  flex-direction: row;
  flex-wrap: nowrap;
}
</style>