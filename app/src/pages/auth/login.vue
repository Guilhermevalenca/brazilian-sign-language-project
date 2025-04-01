<template>
  <AppCard>
      <AppLogo/>
      <h1>Login</h1>
    <AppForm @submit.prevent="submit">
        <label>Email:
          <AppInput type="email" v-model="user.email" placeholder="Email" />
        </label>
        <label>Senha:
          <AppInput type="password" v-model="user.password" placeholder="Password" />
        </label>
      <FormActions>
        <NuxtLink to="/auth/register"> Não Tenho uma conta</NuxtLink>
        <AppButton type="submit">Entrar</AppButton>
      </FormActions>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">

import type { Usertype } from "~/types/User";
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
      const response = AuthService.login(this.user);

      if(await response) {
        try {
          const { data } = await UserService.fetch();
          useUserStore().data = data;

          await useUserStore().fetchIsAdmin();
          this.$router.push('/');
        } catch(error) {
          alert('login bem sucedido, mas algo deu errado ao buscar os seus dados');
        }
      } else {
        alert('login falhou');
      }
    }
  }
});

</script>
