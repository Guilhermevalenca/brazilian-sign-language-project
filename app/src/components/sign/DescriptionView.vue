<template>
  <div class="content-container">
    <iframe
        class="medium-iframe"
        :src="sign?.description?.display"
        allowfullscreen
    >
    </iframe>
    {{ sign?.description?.text }}
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