<template>
  <AppCard>
    <AppLogo/>
    <h1>Cadastro</h1>
    <AppForm @submit.prevent="submit">
      <label>Nome:
        <AppInput v-model="user.name" placeholder="Digite seu nome" />
      </label>
      <label>Email:
        <AppInput type="email" v-model="user.email" placeholder="Digite seu email" />
      </label>
      <label>Senha:
        <AppInput type="password" v-model="user.password" placeholder="Escolha uma senha" />
      </label>
      <label>Confirme sua senha:
        <AppInput type="password" v-model="user.password_confirmation" placeholder="Confirme sua senha" />
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
      const res = await AuthService.register(this.user);
      if(res) {
        const userStore = useUserStore();
        try {
          const { data } = await UserService.fetch();
          userStore.data = data;
          this.$router.push('/auth/check-email-code');
        } catch(error) {
          alert('o cadastro foi bem sucedido, mas algo deu errado ao buscar os seus dados');
        }
      } else {
        alert('não foi possivel cadastra-lo');
      }
    }
  },
});

</script>