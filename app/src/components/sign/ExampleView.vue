<template>
  <div v-if="sign?.example" class="content-container">
    <client-only>
      <iframe
        v-if="sign?.example?.display"
        class="medium-iframe"
        :src="sign?.example?.display"
        allowfullscreen
      />
    </client-only>
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
import type { SignType } from '~/types/Sign';

export default {
  name: 'ExampleView',
  props: {
    sign: Object as PropType<SignType>,
    required: true,
  },
};
</script>

<style scoped lang="scss"></style>
