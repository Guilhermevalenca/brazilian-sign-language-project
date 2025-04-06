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
        :name="'code-' + index"
    />
  </div>
  <button type="submit">Verificar código</button>
</form>
</template>

<script lang="ts">
import AuthService from '~/services/AuthService';

export default defineComponent({
  name: "check-email-code",

  async setup() {
    definePageMeta({
      middleware: 'auth',
    });
  },

  data() {
    return {
      code: ['', '', '', '', '', '', '', ''] as [string, string, string, string, string, string, string, string]
    }
  },

  methods: {
    submit() {
      this.$swal.fire({
        title: 'Verificando codigo...',
      });
      this.$swal.showLoading();
      AuthService.checkEmailCode(this.code.join(''))
        .then(async () => {
          await this.$swal.fire({
            icon: 'success',
            title: 'Tudo certo!',
            timer: 5000,
            showConfirmButton: true,
            confirmButtonText: 'OK',
          })
          this.$router.push('/');
        })
        .catch(async () => {
          await this.$swal.fire({
            icon: 'error',
            title: 'Algo deu errado',
            text: 'Ocorreu um erro, gostaria de tentar novamente ?',
            timer: 10000,
            showConfirmButton: true,
            confirmButtonText: 'Tentar novamente',
          });
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