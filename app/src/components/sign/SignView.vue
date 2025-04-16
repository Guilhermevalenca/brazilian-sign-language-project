<template>
  <div class="content-container">
    <h1>{{ sign?.name }}</h1>
    <iframe
        class="medium-iframe"
        :src="sign?.display"
        allowfullscreen
    >
    </iframe>
    {{ sign?.text }}
  </div>
</template>

<script lang="ts">
export default {
  name: 'SignView',
  props:{
    sign: Object
  }
}
</script>

<style scoped lang="scss">

</style>