<template>
  <AppCard>
      <AppLogo/>
      <h1>Login</h1>
    <AppForm @submit.prevent="submit">
        <label for="email">Email:
          <AppInput id="email" v-model="user.email" placeholder="Email" />
        </label>
        <label for="password">Senha:
          <AppInput id="password" type="password" v-model="user.password" placeholder="Password" />
        </label>
      <FormActions>
        <a href="/auth/register"> Não Tenho uma conta</a>
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
