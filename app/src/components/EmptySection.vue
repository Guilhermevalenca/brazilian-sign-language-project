<template>
  <div v-bind="$attrs">
   <slot/>
  </div>
</template>

<script lang="ts">

  import {attrs} from "ultrahtml";

  export default {
    name: "EmptySection",
    methods: {attrs}
  }
</script>

<style scoped lang="scss">
  div{
    display: flex;
    flex-flow: column;
    align-self: center;
    align-items: center;
    margin: 1em
  }
  p{
    color: $soft-black-2;
  }
</style>