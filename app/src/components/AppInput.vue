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
    width: 25em;
  border-radius: 1em;
  padding: 0.5em;
  border-style: solid;
  border-width: 1px;
  border-color: $primary-color;
}
input:focus{
  border-color: $secondary-color;
  outline: $secondary-color;
}
</style>