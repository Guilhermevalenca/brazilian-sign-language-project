
<template>
  <button  :class="['button-default',variants[variant]]" v-bind="$attrs">
    <slot />
  </button>
</template>
<script lang="ts">
export default {
  name:'ButttonApp',
  props:{
    variant: {
      type: String,
      default: "default",
      validator: (value:string)=>["default", "allow", "deny"].includes(value)
  },
  },
  computed:{
    variants(){
      return{
        default: 'button-default',
        allow: 'button-allow',
        deny: 'button-deny'
      }
    }
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Quantico:ital,wght@0,400;0,700;1,400;1,700&display=swap');

.button-default{
  color: #FFF;

  text-align: center;
  font-family: Quantico;
  font-weight: bold;
  font-size: 8px;
  background-color: #2266D2;
  border:none;
  border-radius: 1vw;
  box-shadow: 0px -2px 0px 0px rgb(0, 0, 0,0.30) inset;
  width: auto;
  min-width: 10vw;
  height: 3vw;
}
.button-default:hover{
  background-color: #1E5AC0;
}
.button-default:active{
  background-color: #1E5AC0;
  box-shadow: 0px -1px 0px 0px rgb(0, 0, 0,0.30) inset;
  transform: translateY(4px)
}
.button-allow{
  background-color: #00ff00;
}
.button-allow:hover{
  background-color: #00e600;
}
.button-allow:active{
  background-color: #00e600;
}
.button-deny{
  background-color: rgb(255,0,0,0.70);
}
.button-deny:hover{
  background-color: rgb(255,0,0,0.80);
}
.button-deny:active{
  background-color: rgb(255,0,0,0.80);
}
</style>