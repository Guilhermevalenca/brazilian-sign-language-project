<template>
  <div ref="videoWrapper" class="content-container">
    <client-only>
      <iframe v-if="sign?.display" class="medium-iframe" :src="sign?.display" allowfullscreen />
    </client-only>
    <p>{{ sign?.text }}</p>
  </div>
</template>

<script lang="ts">
import type { SignType } from '~/types/Sign';

export default {
  name: 'SignView',
  props: {
    sign: Object as PropType<SignType>,
    required: true,
  },
};
</script>

<style scoped lang="scss"></style>
