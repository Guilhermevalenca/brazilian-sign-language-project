<template>
  <textarea
    v-bind="$attrs"
    v-model="input"
  />
  <slot />
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: String,
    required: true,
  },
});
const emit = defineEmits(['update:modelValue']);

const input = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});
</script>

<style scoped lang="scss">
textarea {
  border: solid 0.1rem $primary-color;
  border-radius: 1rem;
  width: 100%;
  box-sizing: border-box;
  min-height: 6rem;
  resize: none;
  padding: 1rem;
}
textarea:focus {
  border-color: $secondary-color;
  outline-color: $secondary-color;
}
textarea::-webkit-scrollbar {
  width: 0.5em;
}
textarea::-webkit-scrollbar-track {
  margin: 0.5em;
  height: auto;
  background-color: transparent;
}
textarea::-webkit-scrollbar-thumb {
  height: auto;
  border-radius: 1em;
  background-color: $secondary-color;
}
</style>
