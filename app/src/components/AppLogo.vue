<template>
  <img src="~/assets/logos/ou-logo-simp.svg" :class="['logo-medium',variants[variant]]" v-bind="$attrs">
  <slot />
</template>

<script lang="ts">
export default{
  name: "AppLogo",
  props:{
    variant:{
      type: String,
      default: "medium",
      validator: (value:string)=>["small","medium", "large"].includes(value)
    },
  },
  computed:{
    variants(){
      return{
        small:"small-logo",
        medium:"medium-logo",
        large:"large-logo"
      }
    }
  }
}
</script>

<style scoped>
  .small-logo{
    width: 50px;
    height: 50px;
  }
  .medium-logo{
    width: 100px;
    height: 100px;
  }
  .large-logo{
    width: 200px;
    height: 200px;
  }
</style>