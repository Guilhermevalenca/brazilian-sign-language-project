<script lang="ts">

export default{
name: "AppCard"
}
</script>

<template>
<div class="card-app">
  <slot/>
</div>
</template>

<style lang="scss" scoped>
.card-app {
  display: flex;
  flex-direction: column;
  gap: 1em;
  justify-self: center;
  align-items: center;
  justify-items: center;
  justify-self: center;
  background-color: ghostwhite;
  padding: 3em;
  min-width: 25em;
  min-height: 20em;
  width: auto;
  height: auto;
  box-shadow: 0 1px 1px  0 rgba(0, 0, 0, 0.2);
  border-radius: 1em;
}
</style>