<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
  name: "AppInput"
})
</script>
<template>
  <input>
</template>

<style scoped>
input{
  width: 25em;
  border-radius: 1em;
  padding: 0.5em;
  border-style: solid;
  border-width: 1px;
  border-color: #2F9E41;
}
input:focus{
  border-color: #2266D2;
  outline: #2266D2;
}
</style>