<template>
  <AppCard>
    <AppLogo/>
    <h1>Cadastro</h1>
    <AppForm @submit.prevent="submit">
      <label>Nome:
        <AppInput
            v-model="user.name"
            placeholder="Digite seu nome"
            name="user.name"
        />
      </label>
      <label>Email:
        <AppInput
            type="email"
            v-model="user.email"
            placeholder="Digite seu email"
            name="user.email"
        />
      </label>
      <label>Senha:
        <AppInput
            type="password"
            v-model="user.password"
            placeholder="Escolha uma senha"
            name="user.password"
        />
      </label>
      <label>Confirme sua senha:
        <AppInput
            type="password"
            v-model="user.password_confirmation"
            placeholder="Confirme sua senha"
            name="user.password_confirmation"
        />
      </label>
      <FormActions>
        <NuxtLink to="/auth/login" margin-left="auto" >Já tenho uma conta</NuxtLink>
        <AppButton type="submit">Cadastrar-se</AppButton>
      </FormActions>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import type { UserType } from "~/types/User";
import useUserStore from '~/stores/useUserStore';
import AuthService from "~/services/AuthService";
import UserService from "~/services/UserService";

export default defineComponent({
  name: "register",

  async setup() {
    definePageMeta({
      middleware: 'guest',
    })
  },

  data() {
    const user: UserType = {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    };
    return {
      user,
    }
  },

  methods: {
    async submit() {
      this.$swal.fire({
        title: 'Registrando...',
      });
      this.$swal.showLoading();
      const res = await AuthService.register(this.user);
      if(res) {
        const updateDataUser = async () => {
          const userStore = useUserStore();
          try {
            const { data } = await UserService.fetch();
            userStore.data = data;
            this.$swal.fire({
              icon: 'success',
              title: 'Registro bem sucedido!',
              timer: 5000,
              showConfirmButton: true,
              confirmButtonText: 'OK',
            })
                .then(() => {
                  this.$router.push('/auth/check-email-code');
                })
          } catch(error) {
            this.$swal.fire({
              icon: 'error',
              title: 'Algo deu errado',
              text: 'Ocorreu um erro, gostaria de tentar novamente ?',
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
                });
          }
        }
        await updateDataUser();
      } else {
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
  },
});

</script>