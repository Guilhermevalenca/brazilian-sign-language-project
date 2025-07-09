<template>
  <div v-if="sign?.description" class="content-container">
    <client-only v-if="sign?.description?.display">
      <iframe
        v-if="sign.description.display"
        class="medium-iframe"
        :src="sign.description.display"
        allowfullscreen
      />
    </client-only>
    <p v-if="sign?.description?.text" class="content-text">
      {{ sign.description.text }}
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
  name: 'DescriptionView',
  props: {
    sign: Object as PropType<SignType>,
    required: true,
  },
};
</script>

<style scoped lang="scss"></style>
