<template>
  <fieldset>
    <p>Perfil:</p>
    <form @submit.prevent="submitProfile">
      <input v-model="user.name" placeholder="Nome" />
      <br />
      <input v-model="user.email" placeholder="Email" />
      <br />
      <button type="submit">Salvar</button>
    </form>
  </fieldset>
  <fieldset>
    <p>Senha:</p>
    <form @submit.prevent="submitPassword">
      <input v-model="user.password" placeholder="Senha Atual" />
      <br />
      <input v-model="user.new_password" placeholder="Nova Senha" />
      <br />
      <input v-model="user.new_password_confirmation" placeholder="Confirmação Senha" />
      <br />
      <button type="submit">Salvar</button>
    </form>
  </fieldset>
  <fieldset>
    <p>Excluir Conta:</p>
    <form @submit.prevent="submitDelete">
      <input v-model="passwordDelete" placeholder="Senha" />
      <button type="submit">Excluir</button>
    </form>
  </fieldset>
</template>

<script lang="ts">
import ProfileService from '~/services/ProfileService';
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
  name: 'profilePage',

  async setup() {
    definePageMeta({
      middleware: 'auth',
    });
  },

  data() {
    return {
      user: {
        name: '',
        email: '',
        password: '',
        new_password: '',
        new_password_confirmation: '',
      },
      passwordDelete: '',
      userStore: null as null | ReturnType<typeof useUserStore>,
    };
  },

  mounted() {
    this.userStore = useUserStore();
  },

  watch: {
    userStore: {
      handler() {
        this.user.email = String(this.userStore?.data?.email ?? '');
        this.user.name = String(this.userStore?.data?.name ?? '');
      },
      deep: true,
      immediate: true,
    },
  },

  methods: {
    async submitProfile() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Salvando perfil...',
        });
        this.$swal.showLoading();
        await ProfileService.updateProfile(this.user);
        if (this.userStore) {
          this.userStore.data.name = this.user.name;
          this.userStore.data.email = this.user.email;
        }
        this.user.name = '';
        this.user.email = '';

        this.$swal.fire({
          icon: 'success',
          title: 'Perfil atualizado com sucesso!',
        });
      } catch (error) {
        this.$swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
      }
    },
    async submitPassword() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Salvando nova senha...',
        });
        this.$swal.showLoading();
        await ProfileService.updatePassword(this.user);
        this.user.password = '';
        this.user.new_password = '';
        this.user.new_password_confirmation = '';
        this.$swal.fire({
          icon: 'success',
          title: 'Senha atualizada com sucesso!',
        });
      } catch (error) {
        this.$swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
      }
    },
    async submitDelete() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Excluindo conta...',
        });
        this.$swal.showLoading();
        await ProfileService.deleteAccount(this.passwordDelete);
        localStorage.removeItem('token');
        delete this.$axios.defaults.headers.common['Authorization'];

        const tokenCookie = useCookie('token');
        tokenCookie.value = null;

        this.userStore!.resetDatas();

        await this.$swal.fire({
          icon: 'success',
          title: 'Conta excluida com sucesso',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo('/auth/login');
      } catch (error) {
        this.$swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
      }
    },
  },
});
</script>
