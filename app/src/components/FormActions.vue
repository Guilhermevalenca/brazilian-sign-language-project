<template>
  <div>
    <slot />
  </div>
</template>

<script lang="ts">
export default {
  name: 'FormActions',
};
</script>

<style scoped>
div {
  display: flex;
  flex: auto;
  gap: 1rem;
  justify-content: flex-end;
  align-items: center;
  align-content: center;
  flex-direction: row;
  flex-wrap: nowrap;
}
</style>
