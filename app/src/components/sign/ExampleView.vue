<template>
  <div class="content-container">
    <iframe
        class="medium-iframe"
        :src="sign?.example?.display"
        allowfullscreen
    >
    </iframe>
    {{ sign?.example?.description }}
  </div>
</template>

<script lang="ts">
export default {
  name: 'ExampleView',
  props:{
    sign: Object
  }
}
</script>

<style scoped lang="scss">

</style>