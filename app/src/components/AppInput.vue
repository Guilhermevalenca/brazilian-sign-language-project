<template>
  <input
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
  >
</template>

<script lang="ts">
export default{
  name: "AppInput",
  props: ['modelValue'],
  emits: ['update:modelValue'],

}
</script>

<style lang="scss" scoped>
input{
  display: flex;
  width: 100%;
  height: 3em;
  border-radius: 1rem;
  padding: 0.5em;
  border: solid 0.1rem $primary-color;
  box-sizing: border-box;
}
input:focus{
  border: solid 0.2rem $secondary-color;
  outline: $secondary-color;
}
</style>