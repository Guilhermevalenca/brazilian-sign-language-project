<template>
  <div v-if="content.length === 0">
    <p> não há nada aqui </p>
  </div>
</template>

<script lang="ts">

  export default {
    name: "EmptySection",
    props: {
      content: {type: [Object, Array], required: true}
    },
  }
</script>

<style scoped lang="scss">

</style>