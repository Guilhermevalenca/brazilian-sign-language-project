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
  gap: 1rem;
  justify-self: center;
  align-items: center;
  justify-content: center;
  background-color: $tertiary-color;
  padding: 3rem;
  width: 35vw;
  height: auto;
  box-shadow: 0 1px 1px  0 rgba(0, 0, 0, 0.2);
  border-radius: 2rem;
}
</style>