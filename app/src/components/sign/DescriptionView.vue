<template>
    <div v-if="sign?.description" class="content-container">
      <iframe
          v-if="sign?.description?.display"
          class="medium-iframe"
          :src="sign?.description?.display"
          allowfullscreen
      >
      </iframe>
      <p class="content-text">
        {{ sign?.description?.text }}
      </p>
    </div>
    <div v-else class="content-container">
      <EmptySection/>
    </div>
</template>

<script lang="ts">
export default {
  name: 'DescriptionView',
  props:{
    sign: Object
  }
}
</script>

<style scoped lang="scss">

</style>