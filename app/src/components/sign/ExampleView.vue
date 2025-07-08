<template>
  <div v-if="sign?.example" class="content-container">
    <iframe
      v-if="sign?.example?.display"
      class="medium-iframe"
      :src="sign?.example?.display"
      allowfullscreen
    >
    </iframe>
    <p class="content-text">
      {{ sign?.example?.description }}
    </p>
  </div>
  <div v-else class="content-container">
    <EmptySection>
      <p>Não há nada aqui...</p>
    </EmptySection>
  </div>
</template>

<script lang="ts">
export default {
  name: 'ExampleView',
  props: {
    sign: Object,
  },
};
</script>

<style scoped lang="scss"></style>
