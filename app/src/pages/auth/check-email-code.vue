<template>
<form @submit.prevent="submit">
  <div class="tw-flex tw-gap-4" @paste.prevent="pasteInputs">
    <input
        v-for="(value, index) in code" :key="index"
        v-model="code[index]"
        type="text"
        maxlength="1"
        pattern="[0-9]"
        class="tw-w-2"
    />
  </div>
  <button type="submit">Verificar código</button>
</form>
</template>

<script lang="ts">

export default defineComponent({
  name: "check-email-code",

  data() {
    return {
      code: ['', '', '', '', '', '', '', ''] as [string, string, string, string, string, string, string, string]
    }
  },

  methods: {
    submit() {
      this.$axios.post('api/users/verify-code', {
        code: this.code.join('')
      })
        .then(() => {
          this.$router.push('/');
        })
        .catch((err) => {
          console.log(err);
        })
    },
    pasteInputs(e: ClipboardEvent) {
      const pastedData = e.clipboardData?.getData("text");

      if(!!pastedData && pastedData.length === 8) {
        for(let i = 0; i < 8; i++) {
          this.code[i] = pastedData[i];
        }
      }
    }
  },

  watch: {
    code() {
      if(this.code.length > 8) {
        this.code.length = 8;
      }
    }
  }
})
</script>

<style scoped lang="scss">

</style>