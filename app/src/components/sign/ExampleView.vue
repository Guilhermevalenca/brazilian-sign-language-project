<template>
  <div class="content-container">
    <iframe
        v-if="sign?.display === String"
        class="medium-iframe"
        :src="sign?.example?.display"
        allowfullscreen
    >
    </iframe>
    <p>
      {{ sign?.example?.description }}
    </p>
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
p{
  padding: 1em;
}
</style>