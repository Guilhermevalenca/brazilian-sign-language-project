<template>
  <div>
    <AppButton
        variant="navigation"
        @click="back()"
    >
      <img src="~/assets/icons/arrow-left.svg" width="24" height="24">
      Voltar
    </AppButton>
  </div>
</template>

<script lang="ts">
export default {
  name: "BackButton",
  methods:{
     back(){
       const router = useRouter()
        if(window.history.length > 1){
          router.back()
        }
        else{
          router.push('/')
        }
    }
  }
}
</script>

<style scoped lang="scss">
div{
  margin: 0.6em;
}
</style>