<template>
  <input v-model="input" >
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: String,
    required: true,
  }
});
const emit = defineEmits(['update:modelValue']);

const input = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});
</script>

<style lang="scss" scoped>
input {
  display: flex;
  width: 100%;
  height: 3em;
  border-radius: 1rem;
  padding: 0.5em;
  border: solid 0.1rem $primary-color;
  box-sizing: border-box;
}
input:focus {
  border: solid 0.2rem $secondary-color;
  outline: $secondary-color;
}
</style>
