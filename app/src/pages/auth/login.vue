<template>
  <AppCard>
      <AppLogo/>
      <h1>Login</h1>
    <AppForm @submit.prevent="submit">
        <label>Email:
          <AppInput
              type="email"
              v-model="user.email"
              placeholder="Email"
              name="user.email"
          />
        </label>
        <label>Senha:
          <AppInput
              type="password"
              v-model="user.password"
              placeholder="Password"
              name="user.password"
          />
        </label>
      <FormActions>
        <NuxtLink to="/auth/register"> Não Tenho uma conta</NuxtLink>
        <AppButton type="submit">Entrar</AppButton>
      </FormActions>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import type { UserType } from "~/types/User";
import AuthService from "~/services/AuthService";
import useUserStore from '~/stores/useUserStore';
import UserService from '~/services/UserService';

export default defineComponent({
  name: "login",

  async setup() {
    definePageMeta({
      middleware: 'guest',
    })
  },

  data() {
    const user: UserType = {
      email: '',
      password: '',
    };
    return {
      user,
    }
  },

  methods: {
    async submit() {
      this.$swal.fire({
        title: 'Realizando login...',
      });
      this.$swal.showLoading();
      try {
        const response = AuthService.login(this.user);

      if(await response) {
        const updateDataUser = async () => {
          try {
            this.$swal.fire({
              icon: 'info',
              title: 'Login bem sucedido',
              text: 'Aguarde enquanto buscamos os seus dados',
            });
            this.$swal.showLoading();
            const { data } = await UserService.fetch();
            useUserStore().data = data;
            await useUserStore().fetchIsAdmin();
            this.$swal.close();
            navigateTo('/');
          } catch(error) {
            this.$swal.fire({
              icon: 'error',
              title: 'Login bem sucedido, mas algo deu errado ao buscar os seus dados',
              timer: 10000,
              showConfirmButton: true,
              confirmButtonText: 'Tentar novamente',
              showCancelButton: true,
              cancelButtonText: 'Cancelar',
            })
                .then((res) => {
                  if(res.isConfirmed) {
                    updateDataUser();
                  }
                })

          }
        }
        await updateDataUser();
      } else {
        this.$swal.fire({
          icon: 'error',
          title: 'Não foi possivel fazer login',
          text: 'Email ou senha incorretos',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
      }
      } catch(e) {
        this.$swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
      }
    }
  }
});

</script>
