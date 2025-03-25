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
  border-radius: 1em;
  padding: 0.5em;
  border-style: solid;
  border-width: 1px;
  box-sizing: border-box;
  border-color: $primary-color;
}
input:focus{
  border-color: $secondary-color;
  outline: $secondary-color;
}
</style>