<template>
  <div ref="videoWrapper" class="content-container">
    <client-only>
      <iframe
          v-if="sign?.display"
          class="medium-iframe"
          :src="sign?.display"
          allowfullscreen
      />
    </client-only>
    <p>{{ sign?.text }}</p>
  </div>
</template>

<script lang="ts">
export default {
  name: 'SignView',
  props: {
    sign: Object,
    required: true,
  },
};
</script>

<style scoped lang="scss"></style>
