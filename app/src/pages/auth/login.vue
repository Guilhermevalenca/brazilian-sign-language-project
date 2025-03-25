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

import User from "~/classes/User";
import AuthService from "~/services/AuthService";
import useUserStore from '~/stores/useUserStore';
import AppCard from '~/components/AppCard.vue'
import AppLogo from "~/components/AppLogo.vue";

export default defineComponent({
  name: "login",
  components: {AppLogo},

  async setup() {
    definePageMeta({
      middleware: 'guest',
    })
  },

  data() {
    const user = new User({
      email: '',
      password: '',
    });
    return {
      user,
    }
  },

  methods: {
    async submit() {
      const response = await AuthService.login(this.user)

      if(response) {
        await useUserStore().data.fetch();
        await useUserStore().fetchIsAdmin();
        this.$router.push('/');
      }
    }
  }
});

</script>
